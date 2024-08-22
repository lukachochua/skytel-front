<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'body_en' => 'required|string',
        ]);

        $news = new News();
        $news->setTranslations('title', [
            'ka' => $request->input('title'),
            'en' => $request->input('title_en')
        ]);
        $news->setTranslations('body', [
            'ka' => $request->input('body'),
            'en' => $request->input('body_en')
        ]);
        $news->tags = $request->input('tags');
        $news->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('news.dashboard')->with('success', 'News created successfully.');
    }

    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            abort(404, 'News not found');
        }

        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'nullable|string|max:255',
            'body_en' => 'nullable|string',
        ]);

        $news->setTranslations('title', [
            'ka' => $request->input('title'),
            'en' => $request->input('title_en')
        ]);
        $news->setTranslations('body', [
            'ka' => $request->input('body'),
            'en' => $request->input('body_en')
        ]);
        $news->tags = $request->input('tags');

        if ($request->hasFile('image')) {
            if ($news->image && Storage::exists('public/' . $news->image)) {
                Storage::delete('public/' . $news->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('news.dashboard')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image && Storage::exists('public/' . $news->image)) {
            Storage::delete('public/' . $news->image);
        }

        $news->delete();
        return redirect()->route('news.dashboard')->with('success', 'News deleted successfully.');
    }
}
