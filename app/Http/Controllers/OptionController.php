<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Option::class);

        $search = $request->get('search', '');

        $options = Option::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.options.index', compact('options', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Option::class);

        return view('app.options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Option::class);

        $validated = $request->validated();

        $option = Option::create($validated);

        return redirect()
            ->route('options.edit', $option)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Option $option): View
    {
        $this->authorize('view', $option);

        return view('app.options.show', compact('option'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Option $option): View
    {
        $this->authorize('update', $option);

        return view('app.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        OptionUpdateRequest $request,
        Option $option
    ): RedirectResponse {
        $this->authorize('update', $option);

        $validated = $request->validated();

        $option->update($validated);

        return redirect()
            ->route('options.edit', $option)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Option $option): RedirectResponse
    {
        $this->authorize('delete', $option);

        $option->delete();

        return redirect()
            ->route('options.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
