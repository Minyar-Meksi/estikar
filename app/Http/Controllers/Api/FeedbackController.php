<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\FeedbackCollection;
use App\Http\Requests\FeedbackStoreRequest;
use App\Http\Requests\FeedbackUpdateRequest;

class FeedbackController extends Controller
{
    public function index(Request $request): FeedbackCollection
    {
        $this->authorize('view-any', Feedback::class);

        $search = $request->get('search', '');

        $feedbacks = Feedback::search($search)
            ->latest()
            ->paginate();

        return new FeedbackCollection($feedbacks);
    }

    public function store(FeedbackStoreRequest $request): FeedbackResource
    {
        $this->authorize('create', Feedback::class);

        $validated = $request->validated();

        $feedback = Feedback::create($validated);

        return new FeedbackResource($feedback);
    }

    public function show(Request $request, Feedback $feedback): FeedbackResource
    {
        $this->authorize('view', $feedback);

        return new FeedbackResource($feedback);
    }

    public function update(
        FeedbackUpdateRequest $request,
        Feedback $feedback
    ): FeedbackResource {
        $this->authorize('update', $feedback);

        $validated = $request->validated();

        $feedback->update($validated);

        return new FeedbackResource($feedback);
    }

    public function destroy(Request $request, Feedback $feedback): Response
    {
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return response()->noContent();
    }
}
