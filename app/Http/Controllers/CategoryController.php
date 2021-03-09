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
use App\Models\Category;
use App\Models\Notification;

class CategoryController extends Controller
{
    //content List
    public function index()
    {
        $category = Category::orderBy('category_name', 'asc')->get();

        return view('category.category', ['category' => $category]);
    }

    public function insert()
    {
        return view('category.insert');
    }

    // public function store_file(Request $request)
    // {
    //     // Input Validation
    //     if ($request->date) {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'date'  => 'required',
    //                 'note'  => 'max:60000',
    //                 'file.*'  => 'required|mimes:doc,docx,jpeg,jpg,png,gif|max:10000',
    //             ],
    //             [
    //                 'file.*.mimes' => 'The attachment must be a file of type:doc, docx, jpeg, jpg, png, gif'
    //             ]
    //         );
    //     } else {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'file.*'  => 'required|mimes:doc,docx,jpeg,jpg,png,gif|max:10000',
    //             ],
    //             [
    //                 'file.*.mimes' => 'The attachment must be a file of type:doc, docx, jpeg, jpg, png, gif'
    //             ]
    //         );
    //     }

    //     $title = htmlspecialchars($request->title);
    //     $note = htmlspecialchars($request->note);
    //     $type = "file";
    //     $user_id = $request->session()->get('user_id');
    //     $date = ($request->date) ? $request->date : date('Y-m-d');
    //     $destination_word = "assets/file/word/";
    //     $destination_img = "assets/file/img/";
    //     $destination_pdf = "assets/file/pdf/";

    //     //Insert Data
    //     $data_content = [
    //         'content_title' => $title,
    //         'content_note' => $note,
    //         'content_type' => $type,
    //         'content_date' => $date,
    //         'content_user_id' => $user_id,
    //         'content_status' => __('content_status.content_status_process'),
    //     ];
    //     $query = Content::create($data_content);

    //     // insert file
    //     foreach ($request->file() as $files) {
    //         foreach ($files as $file) {
    //             $hashName = $file->hashName();
    //             $originalName = $file->getClientOriginalName();
    //             $extension = $file->getClientOriginalExtension();

    //             $data = [
    //                 'content_file_content_id' => $query->content_id,
    //                 'content_file_original_name' => $file->getClientOriginalName(),
    //                 'content_file_hash_name' => $file->hashName(),
    //                 'content_file_base_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
    //                 'content_file_extension' => $file->getClientOriginalExtension(),
    //             ];

    //             if ($file->getClientOriginalExtension() == "docx" || $file->getClientOriginalExtension() == "doc") {

    //                 $file->move($destination_word, $file->hashName());
    //             } else {

    //                 $file->move($destination_img, $file->hashName());
    //             }

    //             Content_file::create($data);
    //         }
    //     }

    //     //Remove From Missed Upload Data
    //     if ($request->date) {
    //         // Missed_upload::where('missed_upload_user_id', $user_id)
    //         //     ->where('missed_upload_date', $request->date)
    //         //     ->delete();
    //     }

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Add Success', //Alert Message 
    //         'New Content Added' //Sub Alert Message
    //     );

    //     return redirect()->route('content');
    // }

    // public function store_link(Request $request)
    // {
    //     // Input Validation
    //     if ($request->date) {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'date'  => 'required',
    //                 'link'  => 'required|max:255',
    //             ]
    //         );
    //     } else {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'link'  => 'required|max:255',
    //             ]
    //         );
    //     }

    //     $title = htmlspecialchars($request->title);
    //     $note = htmlspecialchars($request->note);
    //     $type = "link";
    //     $date = ($request->date) ? $request->date : date('Y-m-d');
    //     $user_id = $request->session()->get('user_id');
    //     $link = htmlspecialchars($request->link);

    //     //Insert Data
    //     $data_content = [
    //         'content_title' => $title,
    //         'content_note' => $note,
    //         'content_type' => $type,
    //         'content_date' => $date,
    //         'content_user_id' => $user_id,
    //         'content_status' => __('content_status.content_status_process'),
    //     ];
    //     $query = Content::create($data_content);

    //     // insert Link
    //     $data = [
    //         'content_link_content_id' => $query->content_id,
    //         'content_link_url' => $link,
    //     ];
    //     Content_link::create($data);

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Add Success', //Alert Message 
    //         'New Content Added' //Sub Alert Message
    //     );

    //     return redirect()->route('content');
    // }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('category.edit', ['category' => $category]);
    }

    // public function update_file(Request $request, $id)
    // {
    //     // Input Validation
    //     if ($request->date) {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'date'  => 'required',
    //                 'file.*'  => 'mimes:doc,docx,jpeg,jpg,png,gif',
    //             ],
    //             [
    //                 'file.*.mimes' => 'The document must be a file of type:doc, docx, jpeg, jpg, png, gif'
    //             ]
    //         );
    //     } else {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'file.*'  => 'mimes:doc,docx,jpeg,jpg,png,gif',
    //             ],
    //             [
    //                 'file.*.mimes' => 'The document must be a file of type:doc, docx, jpeg, jpg, png, gif'
    //             ]
    //         );
    //     }

    //     $content = Content::find($id);
    //     // $content_files = Content_file::where('content_file_content_id', $id)->get();

    //     $title = htmlspecialchars($request->title);
    //     $note = htmlspecialchars($request->note);
    //     $user_id = $request->session()->get('user_id');
    //     $destination_word = "assets/file/word/";
    //     $destination_pdf = "assets/file/pdf/";
    //     $destination_img = "assets/file/img/";
    //     $status = ($content->content_status == __('content_status.content_status_success')) ? __('content_status.content_status_success') : __('content_status.content_status_process');

    //     //Insert Data
    //     if ($request->date) {
    //         $data_content = [
    //             'content_title' => $title,
    //             'content_note' => $note,
    //             'content_date' => $request->date,
    //             'content_type' => $content->content_type,
    //             'content_user_id' => $user_id,
    //             'content_status' => $status,
    //         ];
    //     } else {
    //         $data_content = [
    //             'content_title' => $title,
    //             'content_note' => $note,
    //             'content_type' => $content->content_type,
    //             'content_user_id' => $user_id,
    //             'content_status' => $status,
    //         ];
    //     }

    //     Content::where('content_id', $id)
    //         ->update($data_content);

    //     // FILE
    //     if ($request->file()) {
    //         // insert file
    //         foreach ($request->file() as $files) {
    //             foreach ($files as $file) {
    //                 $hashName = $file->hashName();
    //                 $originalName = $file->getClientOriginalName();
    //                 $extension = $file->getClientOriginalExtension();

    //                 $data = [
    //                     'content_file_content_id' => $content->content_id,
    //                     'content_file_original_name' => $file->getClientOriginalName(),
    //                     'content_file_hash_name' => $file->hashName(),
    //                     'content_file_base_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
    //                     'content_file_extension' => $file->getClientOriginalExtension(),
    //                 ];

    //                 if ($extension == "docx" || $extension == "doc") {
    //                     $file->move($destination_word, $file->hashName());

    //                     // /* Set the PDF Engine Renderer Path */
    //                     // $domPdfPath = base_path('vendor/dompdf/dompdf');
    //                     // \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
    //                     // \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
    //                     // //Load word file
    //                     // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($destination_word . $hashName));

    //                     // //Save it into PDF
    //                     // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
    //                     // $PDFWriter->save(public_path($destination_pdf . pathinfo($hashName, PATHINFO_FILENAME) . '.pdf'));
    //                 } else {
    //                     $file->move($destination_img, $file->hashName());
    //                 }

    //                 Content_file::create($data);
    //             }
    //         }
    //     }

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Update Success', //Alert Message 
    //         'Content Updated' //Sub Alert Message
    //     );

    //     return redirect()->route('content');
    // }
    // public function update_file_remove(Request $request, $id)
    // {
    //     $content_file_id = htmlspecialchars($request->file_id);
    //     $file = Content_file::find($content_file_id);

    //     $file_name = $file->content_file_hash_name;
    //     $user_id = $request->session()->get('user_id');
    //     $destination_word = "assets/file/word/";
    //     $destination_pdf = "assets/file/pdf/";
    //     $destination_img = "assets/file/img/";

    //     if ($file->content_file_extension == "docx" || $file->content_file_extension == "doc") {
    //         File::delete(public_path($destination_word . $file->content_file_hash_name));
    //         // File::delete(public_path($destination_pdf . pathinfo($file->content_file_hash_name, PATHINFO_FILENAME) . '.pdf'));
    //     } else {
    //         File::delete(public_path($destination_img . $file->content_file_hash_name));
    //     }

    //     Content_file::where('content_file_id', $file->content_file_id)->delete();

    //     return $file_name;
    // }

    // public function update_link(Request $request, $id)
    // {
    //     // Input Validation
    //     if ($request->date) {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'date'  => 'required',
    //                 'link'  => 'required|max:255',
    //             ]
    //         );
    //     } else {
    //         $request->validate(
    //             [
    //                 'title'  => 'required|max:255',
    //                 'note'  => 'max:60000',
    //                 'link'  => 'required|max:255',
    //             ]
    //         );
    //     }

    //     $content = Content::find($id);
    //     $content_links = Content_link::where('content_link_content_id', $id)->get();

    //     $title = htmlspecialchars($request->title);
    //     $note = htmlspecialchars($request->note);
    //     $user_id = $request->session()->get('user_id');
    //     $link = htmlspecialchars($request->link);
    //     $status = ($content->content_status == __('content_status.content_status_success')) ? __('content_status.content_status_success') : __('content_status.content_status_process');

    //     //Insert Data
    //     if ($request->date) {
    //         $data_content = [
    //             'content_title' => $title,
    //             'content_note' => $note,
    //             'content_type' => $content->content_type,
    //             'content_date' => $request->date,
    //             'content_user_id' => $user_id,
    //             'content_status' => $status,
    //         ];
    //     } else {
    //         $data_content = [
    //             'content_title' => $title,
    //             'content_note' => $note,
    //             'content_type' => $content->content_type,
    //             'content_user_id' => $user_id,
    //             'content_status' => $status,
    //         ];
    //     }

    //     Content::where('content_id', $id)
    //         ->update($data_content);

    //     foreach ($content_links as $content_link) {
    //         // update Link
    //         $data = [
    //             'content_link_url' => $link,
    //         ];
    //         Content_link::where('content_link_id', $content_link->content_link_id)
    //             ->update($data);
    //     }

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Update Success', //Alert Message 
    //         'Content Updated' //Sub Alert Message
    //     );

    //     return redirect()->route('content');
    // }

    // public function destroy($id)
    // {
    //     $Content = Content::where('content_id', $id)->first();

    //     if ($Content->content_type == "file") {
    //         $content_file = Content_file::where('content_file_content_id', $Content->content_id)->get();

    //         foreach ($content_file as $file) {
    //             if ($file->content_file_extension == "docx" || $file->content_file_extension == "doc") {
    //                 File::delete(public_path('assets/file/word/' . $file->content_file_hash_name));
    //                 // File::delete(public_path('assets/file/pdf/' . pathinfo($file->content_file_hash_name, PATHINFO_FILENAME) . '.pdf'));
    //             } else {
    //                 File::delete(public_path('assets/file/img/' . $file->content_file_hash_name));
    //             }
    //         }

    //         Content_file::where('content_file_content_id', $Content->content_id)->delete();
    //     } elseif ($Content->content_type == "link") {
    //         Content_link::where('content_link_content_id', $Content->content_id)->delete();
    //     }

    //     Content::destroy('content_id', $id);

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Remove Success', //Alert Message 
    //         'Content Removed' //Sub Alert Message
    //     );

    //     return redirect()->route('content');
    // }

}
