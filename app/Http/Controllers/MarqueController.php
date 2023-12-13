<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\View\View;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MarqueStoreRequest;
use App\Http\Requests\MarqueUpdateRequest;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Marque::class);

        $search = $request->get('search', '');

        $marques = Marque::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.marques.index', compact('marques', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Marque::class);

        $categories = Categorie::pluck('name', 'id');

        return view('app.marques.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarqueStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Marque::class);

        $validated = $request->validated();

        $marque = Marque::create($validated);

        return redirect()
            ->route('marques.edit', $marque)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Marque $marque): View
    {
        $this->authorize('view', $marque);

        return view('app.marques.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Marque $marque): View
    {
        $this->authorize('update', $marque);

        $categories = Categorie::pluck('name', 'id');

        return view('app.marques.edit', compact('marque', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        MarqueUpdateRequest $request,
        Marque $marque
    ): RedirectResponse {
        $this->authorize('update', $marque);

        $validated = $request->validated();

        $marque->update($validated);

        return redirect()
            ->route('marques.edit', $marque)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Marque $marque): RedirectResponse
    {
        $this->authorize('delete', $marque);

        $marque->delete();

        return redirect()
            ->route('marques.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
