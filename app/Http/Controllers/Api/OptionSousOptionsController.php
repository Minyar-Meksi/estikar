<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SousOptionResource;
use App\Http\Resources\SousOptionCollection;

class OptionSousOptionsController extends Controller
{
    public function index(
        Request $request,
        Option $option
    ): SousOptionCollection {
        $this->authorize('view', $option);

        $search = $request->get('search', '');

        $sousOptions = $option
            ->sousOptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new SousOptionCollection($sousOptions);
    }

    public function store(Request $request, Option $option): SousOptionResource
    {
        $this->authorize('create', SousOption::class);

        $validated = $request->validate([
            'price' => ['required', 'numeric'],
            'name' => ['required', 'max:255', 'string'],
        ]);

        $sousOption = $option->sousOptions()->create($validated);

        return new SousOptionResource($sousOption);
    }
}
