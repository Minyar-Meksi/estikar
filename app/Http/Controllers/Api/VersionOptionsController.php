<?php
namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptionCollection;

class VersionOptionsController extends Controller
{
    public function index(Request $request, Version $version): OptionCollection
    {
        $this->authorize('view', $version);

        $search = $request->get('search', '');

        $options = $version
            ->options()
            ->search($search)
            ->latest()
            ->paginate();

        return new OptionCollection($options);
    }

    public function store(
        Request $request,
        Version $version,
        Option $option
    ): Response {
        $this->authorize('update', $version);

        $version->options()->syncWithoutDetaching([$option->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Version $version,
        Option $option
    ): Response {
        $this->authorize('update', $version);

        $version->options()->detach($option);

        return response()->noContent();
    }
}
