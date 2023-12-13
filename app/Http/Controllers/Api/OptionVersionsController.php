<?php
namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VersionCollection;

class OptionVersionsController extends Controller
{
    public function index(Request $request, Option $option): VersionCollection
    {
        $this->authorize('view', $option);

        $search = $request->get('search', '');

        $versions = $option
            ->versions()
            ->search($search)
            ->latest()
            ->paginate();

        return new VersionCollection($versions);
    }

    public function store(
        Request $request,
        Option $option,
        Version $version
    ): Response {
        $this->authorize('update', $option);

        $option->versions()->syncWithoutDetaching([$version->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Option $option,
        Version $version
    ): Response {
        $this->authorize('update', $option);

        $option->versions()->detach($version);

        return response()->noContent();
    }
}
