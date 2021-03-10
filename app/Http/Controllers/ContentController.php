<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Support\Facades\File;

use App\Models\Content;
use App\Models\Content_file;
use App\Models\Content_history;
use App\Models\Content_link;
use App\Models\Missed_upload;
use App\Models\Notification;
use App\Models\Category;

class ContentController extends Controller
{
    //content List
    public function index()
    {
        $user_role = Session::get('user_role');

        if ($user_role == "admin") {
            $content = Content::select('contents.*', 'users.user_name', 'users.user_id')
                ->join('users', 'contents.content_user_id', '=', 'users.user_id')
                ->orderBy('updated_at', 'desc')->get();

            return view('content.admin.content', ['content' => $content]);
        } else if ($user_role == "operator") {
            $content = Content::select('contents.*', 'users.user_name')
                ->join('users', 'contents.content_user_id', '=', 'users.user_id')
                ->where('contents.content_user_id', Session::get('user_id'))
                ->orderBy('updated_at', 'desc')->get();

            return view('content.operator.content', ['content' => $content]);
        }
    }

    public function insert()
    {
        $category = Category::orderBy('category_name', 'asc')->get();

        return view('content.operator.insert', ['category' => $category]);
    }

    public function store_file(Request $request)
    {
        // Input Validation
        if ($request->date) {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'date'  => 'required',
                    'category'  => 'required',
                    'note'  => 'max:60000',
                    'file.*'  => 'required|mimes:doc,docx,jpeg,jpg,png,gif|max:10000',
                ],
                [
                    'file.*.mimes' => 'The attachment must be a file of type:doc, docx, jpeg, jpg, png, gif'
                ]
            );
        } else {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'category'  => 'required',
                    'note'  => 'max:60000',
                    'file.*'  => 'required|mimes:doc,docx,jpeg,jpg,png,gif|max:10000',
                ],
                [
                    'file.*.mimes' => 'The attachment must be a file of type:doc, docx, jpeg, jpg, png, gif'
                ]
            );
        }

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $type = "file";
        $user_id = $request->session()->get('user_id');
        $date = ($request->date) ? $request->date : date('Y-m-d');
        $destination_word = "assets/file/word/";
        $destination_img = "assets/file/img/";
        $category = htmlspecialchars($request->category);

        //Insert Data
        $data_content = [
            'content_title' => $title,
            'content_note' => $note,
            'content_type' => $type,
            'content_date' => $date,
            'content_category' => $category,
            'content_user_id' => $user_id,
            'content_status' => __('content_status.content_status_process'),
        ];
        $query = Content::create($data_content);

        // insert file
        foreach ($request->file() as $files) {
            foreach ($files as $file) {
                $hashName = $file->hashName();
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                $data = [
                    'content_file_content_id' => $query->content_id,
                    'content_file_original_name' => $file->getClientOriginalName(),
                    'content_file_hash_name' => $file->hashName(),
                    'content_file_base_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'content_file_extension' => $file->getClientOriginalExtension(),
                ];

                if ($file->getClientOriginalExtension() == "docx" || $file->getClientOriginalExtension() == "doc") {

                    $file->move($destination_word, $file->hashName());
                } else {

                    $file->move($destination_img, $file->hashName());
                }

                Content_file::create($data);
            }
        }

        //Remove From Missed Upload Data
        if ($request->date) {
            // Missed_upload::where('missed_upload_user_id', $user_id)
            //     ->where('missed_upload_date', $request->date)
            //     ->delete();
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Add Success', //Alert Message 
            'New Content Added' //Sub Alert Message
        );

        return redirect()->route('content');
    }

    public function store_link(Request $request)
    {
        // Input Validation
        if ($request->date) {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'date'  => 'required',
                    'category'  => 'required',
                    'link'  => 'required|max:255',
                ]
            );
        } else {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'category'  => 'required',
                    'link'  => 'required|max:255',
                ]
            );
        }

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $category = htmlspecialchars($request->category);
        $type = "link";
        $date = ($request->date) ? $request->date : date('Y-m-d');
        $user_id = $request->session()->get('user_id');
        $link = htmlspecialchars($request->link);

        //Insert Data
        $data_content = [
            'content_title' => $title,
            'content_note' => $note,
            'content_type' => $type,
            'content_category' => $category,
            'content_date' => $date,
            'content_user_id' => $user_id,
            'content_status' => __('content_status.content_status_process'),
        ];
        $query = Content::create($data_content);

        // insert Link
        $data = [
            'content_link_content_id' => $query->content_id,
            'content_link_url' => $link,
        ];
        Content_link::create($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Add Success', //Alert Message 
            'New Content Added' //Sub Alert Message
        );

        return redirect()->route('content');
    }

    public function edit($id)
    {
        $content = Content::find($id);
        $date = date('Y-m-d', strtotime($content->created_at));
        $category = Category::orderBy('category_name', 'asc')->get();

        if ($content->content_type == "file") {

            return view('content.operator.edit_file', ['content' => $content, 'date' => $date, 'category' => $category]);
        } else if ($content->content_type == "link") {


            foreach ($content->content_link()->get() as $link) {
                $content_link = $link->content_link_url;
            }
            return view('content.operator.edit_link', ['content' => $content, 'content_link' => $content_link, 'date' => $date, 'category' => $category]);
        }
    }

    public function update_file(Request $request, $id)
    {
        // Input Validation
        if ($request->date) {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'date'  => 'required',
                    'category'  => 'required',
                    'file.*'  => 'mimes:doc,docx,jpeg,jpg,png,gif',
                ],
                [
                    'file.*.mimes' => 'The document must be a file of type:doc, docx, jpeg, jpg, png, gif'
                ]
            );
        } else {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'category'  => 'required',
                    'file.*'  => 'mimes:doc,docx,jpeg,jpg,png,gif',
                ],
                [
                    'file.*.mimes' => 'The document must be a file of type:doc, docx, jpeg, jpg, png, gif'
                ]
            );
        }

        $content = Content::find($id);
        // $content_files = Content_file::where('content_file_content_id', $id)->get();

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $user_id = $request->session()->get('user_id');
        $destination_word = "assets/file/word/";
        $category = htmlspecialchars($request->category);
        $destination_img = "assets/file/img/";
        $status = ($content->content_status == __('content_status.content_status_success')) ? __('content_status.content_status_success') : __('content_status.content_status_process');

        //Insert Data
        if ($request->date) {
            $data_content = [
                'content_title' => $title,
                'content_note' => $note,
                'content_date' => $request->date,
                'content_category' => $category,
                'content_type' => $content->content_type,
                'content_user_id' => $user_id,
                'content_status' => $status,
            ];
        } else {
            $data_content = [
                'content_title' => $title,
                'content_note' => $note,
                'content_category' => $category,
                'content_type' => $content->content_type,
                'content_user_id' => $user_id,
                'content_status' => $status,
            ];
        }

        Content::where('content_id', $id)
            ->update($data_content);

        // FILE
        if ($request->file()) {
            // insert file
            foreach ($request->file() as $files) {
                foreach ($files as $file) {
                    $hashName = $file->hashName();
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $data = [
                        'content_file_content_id' => $content->content_id,
                        'content_file_original_name' => $file->getClientOriginalName(),
                        'content_file_hash_name' => $file->hashName(),
                        'content_file_base_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'content_file_extension' => $file->getClientOriginalExtension(),
                    ];

                    if ($extension == "docx" || $extension == "doc") {
                        $file->move($destination_word, $file->hashName());

                        // /* Set the PDF Engine Renderer Path */
                        // $domPdfPath = base_path('vendor/dompdf/dompdf');
                        // \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                        // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
                        // //Load word file
                        // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($destination_word . $hashName));

                        // //Save it into PDF
                        // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
                        // $PDFWriter->save(public_path($destination_pdf . pathinfo($hashName, PATHINFO_FILENAME) . '.pdf'));
                    } else {
                        $file->move($destination_img, $file->hashName());
                    }

                    Content_file::create($data);
                }
            }
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Content Updated' //Sub Alert Message
        );

        return redirect()->route('content');
    }
    public function update_file_remove(Request $request, $id)
    {
        $content_file_id = htmlspecialchars($request->file_id);
        $file = Content_file::find($content_file_id);

        $file_name = $file->content_file_hash_name;
        $user_id = $request->session()->get('user_id');
        $destination_word = "assets/file/word/";
        $destination_pdf = "assets/file/pdf/";
        $destination_img = "assets/file/img/";

        if ($file->content_file_extension == "docx" || $file->content_file_extension == "doc") {
            File::delete(public_path($destination_word . $file->content_file_hash_name));
            // File::delete(public_path($destination_pdf . pathinfo($file->content_file_hash_name, PATHINFO_FILENAME) . '.pdf'));
        } else {
            File::delete(public_path($destination_img . $file->content_file_hash_name));
        }

        Content_file::where('content_file_id', $file->content_file_id)->delete();

        return $file_name;
    }

    public function update_link(Request $request, $id)
    {
        // Input Validation
        if ($request->date) {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'date'  => 'required',
                    'category'  => 'required',
                    'link'  => 'required|max:255',
                ]
            );
        } else {
            $request->validate(
                [
                    'title'  => 'required|max:255',
                    'note'  => 'max:60000',
                    'category'  => 'required',
                    'link'  => 'required|max:255',
                ]
            );
        }

        $content = Content::find($id);
        $content_links = Content_link::where('content_link_content_id', $id)->get();

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $category = htmlspecialchars($request->category);
        $user_id = $request->session()->get('user_id');
        $link = htmlspecialchars($request->link);
        $status = ($content->content_status == __('content_status.content_status_success')) ? __('content_status.content_status_success') : __('content_status.content_status_process');

        //Insert Data
        if ($request->date) {
            $data_content = [
                'content_title' => $title,
                'content_note' => $note,
                'content_category' => $category,
                'content_type' => $content->content_type,
                'content_date' => $request->date,
                'content_user_id' => $user_id,
                'content_status' => $status,
            ];
        } else {
            $data_content = [
                'content_title' => $title,
                'content_note' => $note,
                'content_category' => $category,
                'content_type' => $content->content_type,
                'content_user_id' => $user_id,
                'content_status' => $status,
            ];
        }

        Content::where('content_id', $id)
            ->update($data_content);

        foreach ($content_links as $content_link) {
            // update Link
            $data = [
                'content_link_url' => $link,
            ];
            Content_link::where('content_link_id', $content_link->content_link_id)
                ->update($data);
        }

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Content Updated' //Sub Alert Message
        );

        return redirect()->route('content');
    }

    public function destroy($id)
    {
        $Content = Content::where('content_id', $id)->first();

        if ($Content->content_type == "file") {
            $content_file = Content_file::where('content_file_content_id', $Content->content_id)->get();

            foreach ($content_file as $file) {
                if ($file->content_file_extension == "docx" || $file->content_file_extension == "doc") {
                    File::delete(public_path('assets/file/word/' . $file->content_file_hash_name));
                    // File::delete(public_path('assets/file/pdf/' . pathinfo($file->content_file_hash_name, PATHINFO_FILENAME) . '.pdf'));
                } else {
                    File::delete(public_path('assets/file/img/' . $file->content_file_hash_name));
                }
            }

            Content_file::where('content_file_content_id', $Content->content_id)->delete();
        } elseif ($Content->content_type == "link") {
            Content_link::where('content_link_content_id', $Content->content_id)->delete();
        }

        Content::destroy('content_id', $id);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Remove Success', //Alert Message 
            'Content Removed' //Sub Alert Message
        );

        return redirect()->route('content');
    }

    //Content Detail
    public function detail($content_id)
    {
        $content = Content::where('content_id', $content_id)
            ->select('contents.*', 'users.user_name',)
            ->join('users', 'contents.content_user_id', '=', 'users.user_id')
            ->first();

        return view('content.detail', ['content' => $content]);
    }

    public function file_download($content_id, $content_file_name)
    {
        $content_file = Content_file::where('content_file_content_id', $content_id)
            ->where('content_file_hash_name', $content_file_name)
            ->first();

        if ($content_file) {
            if ($content_file->content_file_extension == "docx" || $content_file->content_file_extension == "doc") {
                $file = public_path("assets/file/word/" . $content_file->content_file_hash_name);

                $headers = array(
                    'Content-Type' => mime_content_type($file),
                );

                return response()->download($file, $content_file->content_file_original_name, $headers);
            } else {
                $file = public_path("assets/file/img/" . $content_file->content_file_hash_name);

                $headers = array(
                    'Content-Type' => mime_content_type($file),
                );

                return response()->download($file, $content_file->content_file_original_name, $headers);
            }
        }
    }

    public function file_preview($content_id, $content_file_name)
    {
        // The location of the PDF file 
        // on the server 
        $file_extension = pathinfo($content_file_name, PATHINFO_EXTENSION);

        if ($file_extension == "docx" || $file_extension == "doc") {
            $filename = public_path("assets/file/pdf/" . pathinfo($content_file_name, PATHINFO_FILENAME) . ".pdf");
            $headers = array(
                'Content-Type' => mime_content_type($filename),
            );

            return response()->file($filename, $headers);
        } else {
            $filename = public_path("assets/file/img/" . $content_file_name);
            $headers = array(
                'Content-Type' => mime_content_type($filename),
            );

            return response()->file($filename, $headers);
        }
    }

    public function confirm($content_id)
    {
        $content = Content::where('content_id', $content_id)
            ->select('contents.*', 'users.user_name',)
            ->join('users', 'contents.content_user_id', '=', 'users.user_id')
            ->first();

        return view('content.admin.confirm', ['content' => $content]);
    }

    public function confirm_update(Request $request, $content_id)
    {
        $id = $content_id;

        $content = Content::find($id);

        // Input Validation
        $request->validate(
            [
                'confirm'  => 'required',
                'note'  => 'max:60000',
            ]
        );

        $user_id = $request->session()->get('user_id');
        $notification_user_id = $content->content_user_id;
        $confirm = htmlspecialchars($request->confirm);
        $note = htmlspecialchars($request->note);

        //Update Data
        $data = [
            'content_status' => $confirm,
        ];
        Content::where('content_id', $content_id)->update($data);

        //Insert Data
        $data_content = [
            'content_history_content_id' => $content_id,
            'content_history_status' => $confirm,
            'content_history_note' => $note,
        ];
        Content_history::create($data_content);

        // Insert Notification
        $message = NULL;
        if ($confirm == __('content_status.content_status_success')) {
            $message = 'Admin <span class="badge badge-pill badge-success">' . $confirm . '</span> Your <a href="' . route('content_detail', $id) . '">Submited Content</a>';
        } else if ($confirm == __('content_status.content_status_failed')) {
            $message = 'Admin <span class="badge badge-pill badge-danger">' . $confirm . '</span> Your <a href="' . route('content_detail', $id) . '">Submited Content</a>';
        } else if ($confirm == __('content_status.content_status_process')) {
            $message = 'Admin <span class="badge badge-pill badge-primary">' . $confirm . '</span> Your <a href="' . route('content_detail', $id) . '">Submited Content</a>';
        }

        $data_notif = [
            'notification_user_id' => $notification_user_id,
            'notification_detail' => $message,
            'notification_status' => 0,
            'notification_date' => date('Y-m-d')
        ];
        Notification::create($data_notif);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Status Success', //Alert Message 
            'Content Status Updated' //Sub Alert Message
        );

        return redirect()->route('content');
    }
}
