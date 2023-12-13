<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\View\View;
use App\Models\SousOption;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SousOptionStoreRequest;
use App\Http\Requests\SousOptionUpdateRequest;

class SousOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SousOption::class);

        $search = $request->get('search', '');

        $sousOptions = SousOption::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.sous_options.index', compact('sousOptions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SousOption::class);

        $options = Option::pluck('name', 'id');

        return view('app.sous_options.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SousOptionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SousOption::class);

        $validated = $request->validated();

        $sousOption = SousOption::create($validated);

        return redirect()
            ->route('sous-options.edit', $sousOption)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SousOption $sousOption): View
    {
        $this->authorize('view', $sousOption);

        return view('app.sous_options.show', compact('sousOption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SousOption $sousOption): View
    {
        $this->authorize('update', $sousOption);

        $options = Option::pluck('name', 'id');

        return view('app.sous_options.edit', compact('sousOption', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SousOptionUpdateRequest $request,
        SousOption $sousOption
    ): RedirectResponse {
        $this->authorize('update', $sousOption);

        $validated = $request->validated();

        $sousOption->update($validated);

        return redirect()
            ->route('sous-options.edit', $sousOption)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SousOption $sousOption
    ): RedirectResponse {
        $this->authorize('delete', $sousOption);

        $sousOption->delete();

        return redirect()
            ->route('sous-options.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
