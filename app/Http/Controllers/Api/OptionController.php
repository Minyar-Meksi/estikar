<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionResource;
use App\Http\Resources\OptionCollection;
use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;

class OptionController extends Controller
{
    public function index(Request $request): OptionCollection
    {
        $this->authorize('view-any', Option::class);

        $search = $request->get('search', '');

        $options = Option::search($search)
            ->latest()
            ->paginate();

        return new OptionCollection($options);
    }

    public function store(OptionStoreRequest $request): OptionResource
    {
        $this->authorize('create', Option::class);

        $validated = $request->validated();

        $option = Option::create($validated);

        return new OptionResource($option);
    }

    public function show(Request $request, Option $option): OptionResource
    {
        $this->authorize('view', $option);

        return new OptionResource($option);
    }

    public function update(
        OptionUpdateRequest $request,
        Option $option
    ): OptionResource {
        $this->authorize('update', $option);

        $validated = $request->validated();

        $option->update($validated);

        return new OptionResource($option);
    }

    public function destroy(Request $request, Option $option): Response
    {
        $this->authorize('delete', $option);

        $option->delete();

        return response()->noContent();
    }
}
