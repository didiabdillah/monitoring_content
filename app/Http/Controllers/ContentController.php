<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Support\Facades\File;

use App\Models\Content;
use App\Models\Content_file;
use App\Models\Content_link;

class ContentController extends Controller
{
    //content List
    public function index()
    {
        $user_role = Session::get('user_role');

        if ($user_role == "admin") {
            $content = Content::select('contents.*', 'users.user_name')
                ->join('users', 'contents.content_user_id', '=', 'users.user_id')
                ->orderBy('updated_at', 'desc')->get();

            return view('content.admin.content', ['content' => $content]);
        } else if ($user_role == "operator") {
            $content = Content::select('contents.*', 'users.user_name')
                ->join('users', 'contents.content_user_id', '=', 'users.user_id')
                ->where('contents.content_user_id', Session::get('user_id'))
                ->orderBy('created_at', 'desc')->get();

            return view('content.operator.content', ['content' => $content]);
        }
    }

    public function insert()
    {
        return view('content.operator.insert');
    }

    public function store_file(Request $request)
    {
        // Input Validation
        $request->validate(
            [
                'title'  => 'required|max:255',
                'note'  => 'max:60000',
                'file.*'  => 'required|mimes:docx',
            ],
            [
                'file.*.mimes' => 'The document must be a file of type:docx.'
            ]
        );

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $type = "file";
        $user_id = $request->session()->get('user_id');
        $destination_word = "assets/file/word/";
        $destination_pdf = "assets/file/pdf/";

        //Insert Data
        $data_content = [
            'content_title' => $title,
            'content_note' => $note,
            'content_type' => $type,
            'content_user_id' => $user_id,
            'content_link' => NULL,
            'content_status' => "processing",
            'content_file' => NULL,
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

                $file->move($destination_word, $file->hashName());

                /* Set the PDF Engine Renderer Path */
                $domPdfPath = base_path('vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
                //Load word file
                $Content = \PhpOffice\PhpWord\IOFactory::load(public_path($destination_word . $hashName));

                //Save it into PDF
                $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
                $PDFWriter->save(public_path($destination_pdf . pathinfo($hashName, PATHINFO_FILENAME) . '.pdf'));

                Content_file::create($data);
            }
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
        $request->validate(
            [
                'title'  => 'required|max:255',
                'note'  => 'max:60000',
                'link'  => 'required|max:255',
            ]
        );

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $type = "link";
        $user_id = $request->session()->get('user_id');
        $link = htmlspecialchars($request->link);

        //Insert Data
        $data_content = [
            'content_title' => $title,
            'content_note' => $note,
            'content_type' => $type,
            'content_user_id' => $user_id,
            'content_link' => NULL,
            'content_status' => "processing",
            'content_file' => NULL,
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

    // public function edit($id)
    // {
    //     $provider = Provider::find($id);

    //     return view('provider.edit', ['provider' => $provider]);
    // }

    // public function update(Request $request, $id)
    // {
    //     // Input Validation
    //     $request->validate([
    //         'provider'  => 'required|max:255',
    //     ]);

    //     $provider = htmlspecialchars($request->provider);

    //     //check is provider exist in DB
    //     if (Provider::where('provider_name', $provider)->where('provider_id', '!=', $id)->count() > 0) {
    //         //Flash Message
    //         flash_alert(
    //             __('alert.icon_error'), //Icon
    //             'Update Failed', //Alert Message 
    //             'Provider Name Already Exist' //Sub Alert Message
    //         );

    //         return redirect()->back();
    //     }

    //     //Insert Data
    //     $data = [
    //         'provider_name' => $provider,
    //     ];
    //     Provider::where('provider_id', $id)
    //         ->update($data);

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Update Success', //Alert Message 
    //         'Provider Name Updated' //Sub Alert Message
    //     );

    //     return redirect()->route('provider');
    // }

    public function destroy($id)
    {
        $Content = Content::where('content_id', $id)->first();

        if ($Content->content_type == "file") {
            $content_file = Content_file::where('content_file_content_id', $Content->content_id)->get();

            foreach ($content_file as $file) {
                File::delete(public_path('assets/file/word/' . $file->content_file_hash_name));
                File::delete(public_path('assets/file/pdf/' . pathinfo($file->content_file_hash_name, PATHINFO_FILENAME) . '.pdf'));
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

    // //Provider Detail
    // public function detail($provider_id)
    // {
    //     $provider = Provider_detail::join('providers', 'provider_details.provider_detail_provider_id', '=', 'providers.provider_id')
    //         ->select('provider_details.*', 'providers.provider_name', 'providers.provider_id', 'providers.provider_name')
    //         ->where('provider_detail_provider_id', $provider_id)
    //         ->orderBy('provider_detail_month', 'desc')
    //         ->orderBy('provider_detail_year', 'desc')
    //         ->get();

    //     return view('provider_detail.provider_detail', ['provider' => $provider, 'provider_id' => $provider_id]);
    // }

    public function file_download($content_id, $content_file_name)
    {
        $content_file = Content_file::where('content_file_content_id', $content_id)
            ->where('content_file_hash_name', $content_file_name)
            ->first();

        if ($content_file) {
            $file = public_path("assets/file/word/" . $content_file->content_file_hash_name);

            $headers = array(
                'Content-Type' => mime_content_type($file),
            );

            return response()->download($file, $content_file->content_file_original_name, $headers);
        }
    }

    public function file_preview($content_id, $content_file_name)
    {
        // The location of the PDF file 
        // on the server 
        $filename = public_path("assets/file/pdf/" . pathinfo($content_file_name, PATHINFO_FILENAME) . ".pdf");
        $headers = array(
            'Content-Type' => mime_content_type($filename),
        );

        return response()->file($filename, $headers);
    }
}
