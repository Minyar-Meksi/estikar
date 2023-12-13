<?php

namespace App\Http\Controllers\Api;

use App\Models\SousOption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SousOptionResource;
use App\Http\Resources\SousOptionCollection;
use App\Http\Requests\SousOptionStoreRequest;
use App\Http\Requests\SousOptionUpdateRequest;

class SousOptionController extends Controller
{
    public function index(Request $request): SousOptionCollection
    {
        $this->authorize('view-any', SousOption::class);

        $search = $request->get('search', '');

        $sousOptions = SousOption::search($search)
            ->latest()
            ->paginate();

        return new SousOptionCollection($sousOptions);
    }

    public function store(SousOptionStoreRequest $request): SousOptionResource
    {
        $this->authorize('create', SousOption::class);

        $validated = $request->validated();

        $sousOption = SousOption::create($validated);

        return new SousOptionResource($sousOption);
    }

    public function show(
        Request $request,
        SousOption $sousOption
    ): SousOptionResource {
        $this->authorize('view', $sousOption);

        return new SousOptionResource($sousOption);
    }

    public function update(
        SousOptionUpdateRequest $request,
        SousOption $sousOption
    ): SousOptionResource {
        $this->authorize('update', $sousOption);

        $validated = $request->validated();

        $sousOption->update($validated);

        return new SousOptionResource($sousOption);
    }

    public function destroy(Request $request, SousOption $sousOption): Response
    {
        $this->authorize('delete', $sousOption);

        $sousOption->delete();

        return response()->noContent();
    }
}
