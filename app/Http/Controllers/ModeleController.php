<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use App\Models\Marque;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ModeleStoreRequest;
use App\Http\Requests\ModeleUpdateRequest;

class ModeleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Modele::class);

        $search = $request->get('search', '');

        $modeles = Modele::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.modeles.index', compact('modeles', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Modele::class);

        $marques = Marque::pluck('name', 'id');

        return view('app.modeles.create', compact('marques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModeleStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Modele::class);

        $validated = $request->validated();

        $modele = Modele::create($validated);

        return redirect()
            ->route('modeles.edit', $modele)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Modele $modele): View
    {
        $this->authorize('view', $modele);

        return view('app.modeles.show', compact('modele'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Modele $modele): View
    {
        $this->authorize('update', $modele);

        $marques = Marque::pluck('name', 'id');

        return view('app.modeles.edit', compact('modele', 'marques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ModeleUpdateRequest $request,
        Modele $modele
    ): RedirectResponse {
        $this->authorize('update', $modele);

        $validated = $request->validated();

        $modele->update($validated);

        return redirect()
            ->route('modeles.edit', $modele)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Modele $modele): RedirectResponse
    {
        $this->authorize('delete', $modele);

        $modele->delete();

        return redirect()
            ->route('modeles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
