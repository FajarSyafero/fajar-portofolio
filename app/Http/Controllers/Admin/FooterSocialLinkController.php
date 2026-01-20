<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use App\DataTables\FooterSocialLinkDataTable;
use App\Models\FooterSocialLink;

use function Flasher\Toastr\Prime\toastr;

class FooterSocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterSocialLinkDataTable $dataTable)
    {
        return $dataTable->render('admin.footer-social-link.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer-social-link.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string',
            'url' => 'required|string',
        ]);

        $social = new \App\Models\FooterSocialLink();
        $social->icon = $request->icon;
        $social->url = $request->url;
        $social->save();

        toastr('Footer Social Link Created Successfully');

        return redirect()->route('admin.footer-social.index');
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
        $social = \App\Models\FooterSocialLink::findOrFail($id);
        return view ('admin.footer-social-link.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => 'required|string',
            'url' => 'required|string',
        ]);

        $social = FooterSocialLink::findOrFail($id);
        $social->icon = $request->icon;
        $social->url = $request->url;
        $social->save();

        toastr('Footer Social Link Update Successfully');

        return redirect()->route('admin.footer-social.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $social = FooterSocialLink::findOrFail($id);
        $social->delete();
    }
}
