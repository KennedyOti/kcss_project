<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('portal.content.index', compact('pages'));
    }

    public function create()
    {
        return view('portal.content.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'content' => 'required',
        ]);

        Page::create($validated);

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('portal.content.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'content' => 'required',
        ]);

        $page->update($validated);

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    public function show(Page $page)
    {
        return view('portal.content.show', compact('page'));
    }


    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
