<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Creator;

class SupportController extends Controller
{
    /**
     * Store a new support donation for the creator.
     */
    public function store(Request $request, $slug)
    {
        $creator = Creator::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'supporter_name' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999'],
        ]);

        $creator->supports()->create($validated);

        return back()->with('success', 'Thank you for your support!');
    }
}
