<?php

namespace App\Http\Controllers\Api;

use App\Models\Modele;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModeleResource;
use App\Http\Resources\ModeleCollection;
use App\Http\Requests\ModeleStoreRequest;
use App\Http\Requests\ModeleUpdateRequest;

class ModeleController extends Controller
{
    public function index(Request $request): ModeleCollection
    {
        $this->authorize('view-any', Modele::class);

        $search = $request->get('search', '');

        $modeles = Modele::search($search)
            ->latest()
            ->paginate();

        return new ModeleCollection($modeles);
    }

    public function store(ModeleStoreRequest $request): ModeleResource
    {
        $this->authorize('create', Modele::class);

        $validated = $request->validated();

        $modele = Modele::create($validated);

        return new ModeleResource($modele);
    }

    public function show(Request $request, Modele $modele): ModeleResource
    {
        $this->authorize('view', $modele);

        return new ModeleResource($modele);
    }

    public function update(
        ModeleUpdateRequest $request,
        Modele $modele
    ): ModeleResource {
        $this->authorize('update', $modele);

        $validated = $request->validated();

        $modele->update($validated);

        return new ModeleResource($modele);
    }

    public function destroy(Request $request, Modele $modele): Response
    {
        $this->authorize('delete', $modele);

        $modele->delete();

        return response()->noContent();
    }
}
