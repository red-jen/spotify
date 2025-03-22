<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use Intervention\Image\Facades\Image;

class DesignController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'design_file' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);
        
        $image = $request->file('design_file');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        
        // Process and save the image
        $img = Image::make($image->getRealPath());
        $img->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $img->save(storage_path('app/public/designs/' . $filename));
        
        // Save design record
        $design = new Design();
        $design->filename = $filename;
        $design->user_id = auth()->id();
        $design->save();
        
        return redirect()->route('designs.index')
            ->with('success', 'Design uploaded successfully!');
    }
}
