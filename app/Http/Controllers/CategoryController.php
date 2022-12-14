<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('backend.category.manage', compact('categories'));
    }
    public function create() 
    {
        return view('backend.category.create');
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|max:40'
        ],[
            'name.required' => 'The Category field is required.'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('msg', 'Category Add Successfully');
    }

    public function edit($cat_id) {
        $category = Category::find($cat_id);
        return view('backend.category.edit', compact('category'));
    }
    public function update(Request $request, $cat_id) {
        $request->validate([
            'name' => 'required|max:40'
        ],[
            'name.required' => 'The Category field is required.'
        ]);
        $category = Category::find($cat_id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('category-manage')->with('msg', 'Category Updated Successfully');
    }

    public function delete($cat_id) {
        $category = Category::find($cat_id);
        $category->delete();
        $productDeleteImage = DB::table('products')->where('category_id', $cat_id)->value('image');
        DB::table('brands')->where('category_id', $cat_id)->delete();
        DB::table('products')->where('category_id', $cat_id)->delete();
        if(File::exists($productDeleteImage)){
            unlink($productDeleteImage);
        }
        return redirect()->back()->with('msg', 'Category deleted Successfully');
    }
}
