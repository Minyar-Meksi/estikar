<?php

namespace App\Http\Controllers\Api;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarqueResource;
use App\Http\Resources\MarqueCollection;

class CategorieMarquesController extends Controller
{
    public function index(
        Request $request,
        Categorie $categorie
    ): MarqueCollection {
        $this->authorize('view', $categorie);

        $search = $request->get('search', '');

        $marques = $categorie
            ->marques()
            ->search($search)
            ->latest()
            ->paginate();

        return new MarqueCollection($marques);
    }

    public function store(
        Request $request,
        Categorie $categorie
    ): MarqueResource {
        $this->authorize('create', Marque::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $marque = $categorie->marques()->create($validated);

        return new MarqueResource($marque);
    }
}
