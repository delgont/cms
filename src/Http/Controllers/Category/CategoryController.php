<?php

namespace Delgont\Cms\Http\Controllers\Category;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Cms\Models\Category\Category;

class CategoryController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount(['posts'])->get();
        return (request()->expectsJson()) ? response()->json($categories) : view('delgont::categories.index', compact(['categories']));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'not yet';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
            'parent' => 'nullable'
        ]);

        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent_id = ($request->parent) ? $request->parent : null;

        $category->save();
        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Category Created Successfully', 'category' => $category], 200) : back()->withInput()->with('created', 'Category Created Successfully');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return (request()->expectsJson()) ? response()->json($category) : view('pagman::categories.show', compact(['category']));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all();
        return view('pagman::categories.edit', compact(['category', 'categories']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,ponamest_title,'.$id,
            'description' => 'nullable',
            'parent' => 'nullable'
        ]);

       $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return ($request->expectsJson()) ? response()->json(['success' => true,'message' => 'Category Updated Successfully'], 200) : back()->withInput()->with('updated', 'Category Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return (request()->expectsJson()) ? response()->json(['success' => true, 'message' => 'Category Deleted Successfully']) : back()->with('deleted', 'Category deleted successfully');
    }


}
