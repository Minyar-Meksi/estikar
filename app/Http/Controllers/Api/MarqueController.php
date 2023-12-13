<?php

namespace App\Http\Controllers\Api;

use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarqueResource;
use App\Http\Resources\MarqueCollection;
use App\Http\Requests\MarqueStoreRequest;
use App\Http\Requests\MarqueUpdateRequest;

class MarqueController extends Controller
{
    public function index(Request $request): MarqueCollection
    {
        $this->authorize('view-any', Marque::class);

        $search = $request->get('search', '');

        $marques = Marque::search($search)
            ->latest()
            ->paginate();

        return new MarqueCollection($marques);
    }

    public function store(MarqueStoreRequest $request): MarqueResource
    {
        $this->authorize('create', Marque::class);

        $validated = $request->validated();

        $marque = Marque::create($validated);

        return new MarqueResource($marque);
    }

    public function show(Request $request, Marque $marque): MarqueResource
    {
        $this->authorize('view', $marque);

        return new MarqueResource($marque);
    }

    public function update(
        MarqueUpdateRequest $request,
        Marque $marque
    ): MarqueResource {
        $this->authorize('update', $marque);

        $validated = $request->validated();

        $marque->update($validated);

        return new MarqueResource($marque);
    }

    public function destroy(Request $request, Marque $marque): Response
    {
        $this->authorize('delete', $marque);

        $marque->delete();

        return response()->noContent();
    }
}
