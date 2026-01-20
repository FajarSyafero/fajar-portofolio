<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PortfolioItemDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function Flasher\Toastr\Prime\toastr;

class PortfolioItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PortfolioItemDataTable $dataTable)
    {
        return $dataTable->render('admin.portfolio-item.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();

        return view('admin.portfolio-item.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5000'],
            'title' => ['required', 'max:200'],
            'description' => ['required'],
            'category_id' => ['required', 'numeric'],
            'client' => ['max:200'],
            'website' => ['url'],
        ]);

        $imagePath = handleUpload('image');

        $portfolioItem = new \App\Models\PortfolioItem();
        $portfolioItem->image = $imagePath;
        $portfolioItem->title = $request->title;
        $portfolioItem->description = $request->description;
        $portfolioItem->category_id = $request->category_id;
        $portfolioItem->client = $request->client;
        $portfolioItem->website = $request->website;
        $portfolioItem->save();

        toastr()->success('Portfolio Item Created Successfully');

        return Redirect()->route('admin.portfolio-item.index');
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
        $categories = \App\Models\Category::all();
        $portfolioItem = \App\Models\PortfolioItem::findOrFail($id);
        return view('admin.portfolio-item.edit' , compact('categories', 'portfolioItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['image', 'max:5000'],
            'title' => ['required', 'max:200'],
            'description' => ['required'],
            'category_id' => ['required', 'numeric'],
            'client' => ['max:200'],
            'website' => ['url'],
        ]);

        $portfolioItem = \App\Models\PortfolioItem::findOrFail($id);

        $imagePath = handleUpload('image', $portfolioItem);

        $portfolioItem->image = (!empty($imagePath) ? $imagePath : $portfolioItem->image);
        $portfolioItem->title = $request->title;
        $portfolioItem->description = $request->description;
        $portfolioItem->category_id = $request->category_id;
        $portfolioItem->client = $request->client;
        $portfolioItem->website = $request->website;
        $portfolioItem->save();

        toastr()->success('Profile Item Updated Successfully!');

        return redirect()->route('admin.portfolio-item.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolioItem = \App\Models\PortfolioItem::findOrFail($id);
        deleteFileIfExist($portfolioItem->image);
        $portfolioItem->delete();
    }
}
