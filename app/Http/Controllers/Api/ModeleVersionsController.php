<?php

namespace App\Http\Controllers\Api;

use App\Models\Modele;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use App\Http\Resources\VersionCollection;

class ModeleVersionsController extends Controller
{
    public function index(Request $request, Modele $modele): VersionCollection
    {
        $this->authorize('view', $modele);

        $search = $request->get('search', '');

        $versions = $modele
            ->versions()
            ->search($search)
            ->latest()
            ->paginate();

        return new VersionCollection($versions);
    }

    public function store(Request $request, Modele $modele): VersionResource
    {
        $this->authorize('create', Version::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'picture' => ['image', 'max:1024', 'nullable'],
            'year' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('public');
        }

        $version = $modele->versions()->create($validated);

        return new VersionResource($version);
    }
}
