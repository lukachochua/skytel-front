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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('sliders', 'public');

        $slider = new Slider();
        $slider->setTranslations('title', [
            'ka' => $request->input('title'),
            'en' => $request->input('title_en')
        ]);
        $slider->setTranslations('description', [
            'ka' => $request->input('description'),
            'en' => $request->input('description_en')
        ]);
        $slider->image = $path;
        $slider->order = Slider::max('order') + 1;

        $slider->save();

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            $path = $request->file('image')->store('sliders', 'public');
            $slider->image = $path;
        }

        $slider->setTranslations('title', [
            'ka' => $validated['title'],
            'en' => $validated['title_en']
        ]);

        $slider->setTranslations('description', [
            'ka' => $validated['description'],
            'en' => $validated['description_en']
        ]);

        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);

        return view('sliders.show', compact('slider'));
    }
}
