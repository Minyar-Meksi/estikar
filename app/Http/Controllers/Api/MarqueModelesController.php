<?php

namespace App\Http\Controllers\Api;

use App\Models\Marque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModeleResource;
use App\Http\Resources\ModeleCollection;

class MarqueModelesController extends Controller
{
    public function index(Request $request, Marque $marque): ModeleCollection
    {
        $this->authorize('view', $marque);

        $search = $request->get('search', '');

        $modeles = $marque
            ->modeles()
            ->search($search)
            ->latest()
            ->paginate();

        return new ModeleCollection($modeles);
    }

    public function store(Request $request, Marque $marque): ModeleResource
    {
        $this->authorize('create', Modele::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $modele = $marque->modeles()->create($validated);

        return new ModeleResource($modele);
    }
}
