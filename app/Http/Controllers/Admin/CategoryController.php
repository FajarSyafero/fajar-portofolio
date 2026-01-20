<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\PortfolioItem;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.portfolio-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200']
        ]);

        $create = new \App\Models\Category();
        $create->name = $request->name;
        $create->slug = \Illuminate\Support\Str::slug($request->name);
        $create->save();
        toastr()
    ->addSuccess('Category Updated Successfully!');

        return Redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.portfolio-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200']
        ]);

        $category = \App\Models\Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name);
        $category->save();
        toastr()
    ->addSuccess('Category Update Successfully!');

        return Redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $hasItem = PortfolioItem::where('category_id', $category->id)->count();
        if ($hasItem == 0) {
            $category->delete();
            return true;
        }
        return response(['status' => 'error']);
    }
}
