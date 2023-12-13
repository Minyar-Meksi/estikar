<?php

namespace App\Http\Controllers\Api;

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VersionCollection;
use App\Http\Requests\VersionStoreRequest;
use App\Http\Requests\VersionUpdateRequest;

class VersionController extends Controller
{
    public function index(Request $request): VersionCollection
    {
        $this->authorize('view-any', Version::class);

        $search = $request->get('search', '');

        $versions = Version::search($search)
            ->latest()
            ->paginate();

        return new VersionCollection($versions);
    }

    public function store(VersionStoreRequest $request): VersionResource
    {
        $this->authorize('create', Version::class);

        $validated = $request->validated();
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('public');
        }

        $version = Version::create($validated);

        return new VersionResource($version);
    }

    public function show(Request $request, Version $version): VersionResource
    {
        $this->authorize('view', $version);

        return new VersionResource($version);
    }

    public function update(
        VersionUpdateRequest $request,
        Version $version
    ): VersionResource {
        $this->authorize('update', $version);

        $validated = $request->validated();

        if ($request->hasFile('picture')) {
            if ($version->picture) {
                Storage::delete($version->picture);
            }

            $validated['picture'] = $request->file('picture')->store('public');
        }

        $version->update($validated);

        return new VersionResource($version);
    }

    public function destroy(Request $request, Version $version): Response
    {
        $this->authorize('delete', $version);

        if ($version->picture) {
            Storage::delete($version->picture);
        }

        $version->delete();

        return response()->noContent();
    }
}
