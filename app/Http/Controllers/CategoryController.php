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

    public function store(Request $request)
    {
        $request->validate(
            [
                'category'  => 'required|max:255',
            ]
        );

        $category = htmlspecialchars($request->category);
        $user_id = $request->session()->get('user_id');

        //Insert Data
        $data = [
            'category_name' => $category,
        ];
        Category::create($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Add Success', //Alert Message 
            'New Category Added' //Sub Alert Message
        );

        return redirect()->route('category');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        // Input Validation
        $request->validate(
            [
                'category'  => 'required|max:255',
            ]
        );

        $category = htmlspecialchars($request->category);
        $user_id = $request->session()->get('user_id');

        //UpdateData
        $data = [
            'category_name' => $category,
        ];

        Category::where('category_id', $id)
            ->update($data);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Update Success', //Alert Message 
            'Category Updated' //Sub Alert Message
        );

        return redirect()->route('category');
    }

    public function destroy($id)
    {
        Category::destroy('category_id', $id);

        //Flash Message
        flash_alert(
            __('alert.icon_success'), //Icon
            'Remove Success', //Alert Message 
            'Category Removed' //Sub Alert Message
        );

        return redirect()->route('category');
    }
}
