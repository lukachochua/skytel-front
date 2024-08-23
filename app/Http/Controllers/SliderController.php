<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $path,
            'order' => Slider::max('order') + 1,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from storage
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            // Store the new image and get its path
            $path = $request->file('image')->store('sliders', 'public');

            // Update the slider record with the new image path
            $validated['image'] = $path;
        }

        // Update other slider details (title, description)
        $slider->update($validated);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
