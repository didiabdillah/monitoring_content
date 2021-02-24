<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

use App\Models\Content;
use App\Models\Content_file;

class ContentController extends Controller
{
    //content List
    public function index()
    {
        $user_role = Session::get('user_role');

        if ($user_role == "admin") {
            $content = Content::select('contents.*', 'users.user_name')
                ->join('users', 'contents.content_user_id', '=', 'users.user_id')
                ->orderBy('created_at', 'desc')->get();

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

    public function store(Request $request)
    {
        // Input Validation
        $request->validate(
            [
                'title'  => 'required|max:255',
                'note'  => 'max:60000',
                'file.*'  => 'required|mimes:doc,docx',
                'type'  => 'required',
            ],
            [
                'file.*.mimes' => 'The document must be a file of type: doc, docx.'
            ]
        );

        $title = htmlspecialchars($request->title);
        $note = htmlspecialchars($request->note);
        $type = htmlspecialchars($request->type);
        $user_id = $request->session()->get('user_id');
        $destination = "assets/file/";

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

                $data = [
                    'content_file_content_id' => $query->content_id,
                    'content_file_original_name' => $file->getClientOriginalName(),
                    'content_file_hash_name' => $file->hashName(),
                    'content_file_base_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'content_file_extension' => $file->getClientOriginalExtension(),
                ];

                $file->move($destination, $file->hashName());

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

    // public function destroy($id)
    // {
    //     Provider::destroy('provider_id', $id);

    //     //Flash Message
    //     flash_alert(
    //         __('alert.icon_success'), //Icon
    //         'Remove Success', //Alert Message 
    //         'Provider Name Removed' //Sub Alert Message
    //     );

    //     return redirect()->route('provider');
    // }

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
            $file = public_path("assets/file/" . $content_file->content_file_hash_name);

            $headers = array(
                'Content-Type' => mime_content_type($file),
            );

            return response()->download($file, $content_file->content_file_original_name, $headers);
        }
    }
}
