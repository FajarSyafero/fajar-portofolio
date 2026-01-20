<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FooterUsefulLinkDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterUsefulLink;

class FooterUsefulLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterUsefulLinkDataTable $dataTable)
    {
        return $dataTable->render('admin.footer-useful-link.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer-useful-link.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
        ]);

        $link = new \App\Models\FooterUsefulLink();
        $link -> name = $request->name;
        $link -> url = $request->url;
        $link -> save();

        toastr('Footer Useful Link Created Successfully');
        return redirect()->route('admin.footer-useful-links.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $link = \App\Models\FooterUsefulLink::findOrFail($id);
        return view('admin.footer-useful-link.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
        ]);

        $link = FooterUsefulLink::findOrFail($id);
        $link -> name = $request->name;
        $link -> url = $request->url;
        $link -> save();

        toastr('Footer Useful Link Created Successfully');
        return redirect()->route('admin.footer-useful-links.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $link = FooterUsefulLink::findOrFail($id);
        $link -> delete ();
    }
}
