<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TinyMceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $file = $request->file('file');
        $destination = public_path('uploads/tinymce');

        if (! File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time() . '_' . Str::random(12) . '.' . $extension;

        $file->move($destination, $filename);

        return response()->json([
            'location' => url('uploads/tinymce/' . $filename),
        ]);
    }
}
