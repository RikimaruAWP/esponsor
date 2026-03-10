<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Creator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CreatorController extends Controller
{
    /**
     * Show the public profile of the creator.
     */
    public function show($slug)
    {
        // Buscamos al creador por su slug y cargamos sus links públicos
        $creator = Creator::with('links')->where('slug', $slug)->firstOrFail();

        return Inertia::render('PublicProfile', [
            'creator' => $creator
        ]);
    }

    /**
     * Update the authenticated user's creator profile.
     */
    public function update(Request $request)
    {
        $creator = $request->user()->creator;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Aseguramos que el slug sea único, ignorando el actual del creador
            'slug' => ['required', 'string', 'max:255', Rule::unique('creators')->ignore($creator->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar_url' => ['nullable'], // Quitamos validación de url simple para procesarlo manualmente luego
        ]);

        // Manejo de la imagen subida localmente
        if ($request->hasFile('avatar_image')) {
            $request->validate([
                'avatar_image' => ['image', 'max:5120'], // Máximo 5MB
            ]);

            // Si el creador ya tenía un avatar localmente, lo borramos
            if ($creator->avatar_url && str_contains($creator->avatar_url, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', parse_url($creator->avatar_url, PHP_URL_PATH));
                Storage::disk('public')->delete($oldPath);
            }

            // Guardamos la nueva imagen en storage/app/public/avatars
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $validated['avatar_url'] = '/storage/' . $path;
        }

        $creator->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
