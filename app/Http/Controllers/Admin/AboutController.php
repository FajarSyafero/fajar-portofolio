<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\File;
use function Flasher\Toastr\Prime\toastr;


class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi di sini (Sesuai input yang ada di Blade About)
        $request->validate([
            'image' => ['nullable', 'image', 'max:5000'],
            'title' => ['required', 'max:200'],
            'description' => ['required', 'max:5000'],
            'resume' => ['nullable', 'mimes:pdf,doc,docx', 'max:10000']
        ]);

        $about = About::first();
        $imagePath = handleUpload('image', $about);
        $resumePath = handleUpload('resume', $about);

        About::updateOrCreate(
            ['id' => $id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'image' => (!empty($imagePath) ? $imagePath : $about?->image),
                'resume' => (!empty($resumePath) ? $resumePath : $about?->resume)
            ]
        );

        return redirect()->back()->with('success', 'About section updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'title' => ['required', 'max:200'],
            'description' => ['required', 'max:5000'],
            'resume' => ['mimes:pdf,doc,docx', 'max:10000']
        ]);

        $about = About::first();
        $imagePath = handleUpload('image', $about);
        $resumePath = handleUpload('resume', $about);

        About::updateOrCreate(
            ['id' => $id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'image' => (!empty($imagePath) ? $imagePath : $about->image),
                'resume' => (!empty($resumePath) ? $resumePath : $about->resume)
            ]
        );
    }

    public function resumeDownload()
    {
        $about = About::first();
        return response()->download(public_path($about->resume));
    }
}
