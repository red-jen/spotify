<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\Category;
use Intervention\Image\Facades\Image;

class DesignController extends Controller
{
    public function store(Request $request)
    {
        // Code from previous commit...
    }
    
    public function edit(Design $design)
    {
        // Authorization check
        $this->authorize('update', $design);
        
        $categories = Category::all();
        return view('designer.designs.edit', compact('design', 'categories'));
    }
    
    public function update(Request $request, Design $design)
    {
        // Authorization check
        $this->authorize('update', $design);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        
        $design->title = $request->title;
        $design->description = $request->description;
        $design->price = $request->price;
        $design->save();
        
        // Process new image if uploaded
        if ($request->hasFile('design_file')) {
            $request->validate([
                'design_file' => 'image|mimes:jpeg,png,jpg|max:10240',
            ]);
            
            // Delete old image file
            if (file_exists(storage_path('app/public/designs/' . $design->filename))) {
                unlink(storage_path('app/public/designs/' . $design->filename));
            }
            
            // Process and save new image
            $image = $request->file('design_file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            $img = Image::make($image->getRealPath());
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $img->save(storage_path('app/public/designs/' . $filename));
            
            $design->filename = $filename;
            $design->save();
        }
        
        return redirect()->route('designs.edit', $design)
            ->with('success', 'Design updated successfully!');
    }
}
