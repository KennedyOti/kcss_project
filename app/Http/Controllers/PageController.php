<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the pages with filters.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filters = [
            'title' => $request->input('title'),
            'meta_title' => $request->input('meta_title'),
        ];

        // Query with filters
        $pages = Page::query()
            ->when($filters['title'], function ($query, $title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->when($filters['meta_title'], function ($query, $metaTitle) {
                $query->where('meta_title', 'like', "%{$metaTitle}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('portal.content.index', compact('pages', 'filters'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('portal.content.create');
    }

    /**
     * Store a newly created page in storage.
     */
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

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('portal.content.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
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

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        return view('portal.content.show', compact('page'));
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }
}
