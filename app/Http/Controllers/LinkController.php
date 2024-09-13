<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $navbarLinks = Link::where('type', 'navbar')->get();
        $footerLinks = Link::where('type', 'footer')->get();

        return view('admin.links.index', compact('navbarLinks', 'footerLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'    => 'required|string|max:255',
            'label_en' => 'required|string|max:255',
            'route_name' => 'required|string|max:255',
            'type'     => 'required|in:navbar,footer',
        ]);

        $link = new Link();

        $link->setTranslations('label', [
            'ka' => $request->input('label'),
            'en' => $request->input('label_en'),
        ]);

        $link->route_name = $request->input('route_name');
        $link->type = $request->input('type');

        $link->save();

        return redirect()->route('links.index')->with('success', 'Link created successfully.');
    }



    public function edit(Link $link)
    {
        return view('admin.links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $request->validate([
            'label'    => 'required|string|max:255',
            'label_en' => 'required|string|max:255',
            'route_name' => 'required|string|max:255',
            'type'     => 'required|in:navbar,footer',
        ]);

        $link->setTranslations('label', [
            'ka' => $request->input('label'),
            'en' => $request->input('label_en'),
        ]);

        $link->route_name = $request->input('route_name');
        $link->type = $request->input('type');

        $link->save();

        return redirect()->route('links.index')->with('success', 'Link updated successfully.');
    }



    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted successfully.');
    }
}
