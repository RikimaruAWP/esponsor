<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Link;

class LinkController extends Controller
{
    /**
     * Store a newly created link in storage.
     */
    public function store(Request $request)
    {
        $creator = $request->user()->creator;

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $creator->links()->create($validated);

        return back()->with('success', 'Link added successfully.');
    }

    /**
     * Remove the specified link from storage.
     */
    public function destroy(Request $request, Link $link)
    {
        // Autorización simple: verificar que el link pertenece al creador actual
        if ($link->creator_id !== $request->user()->creator->id) {
            abort(403, 'Unauthorized action.');
        }

        $link->delete();

        return back()->with('success', 'Link deleted successfully.');
    }
}
