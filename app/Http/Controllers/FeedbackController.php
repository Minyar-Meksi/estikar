<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FeedbackStoreRequest;
use App\Http\Requests\FeedbackUpdateRequest;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Feedback::class);

        $search = $request->get('search', '');

        $feedbacks = Feedback::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.feedbacks.index', compact('feedbacks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Feedback::class);

        return view('app.feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Feedback::class);

        $validated = $request->validated();

        $feedback = Feedback::create($validated);

        return redirect()
            ->route('feedbacks.edit', $feedback)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Feedback $feedback): View
    {
        $this->authorize('view', $feedback);

        return view('app.feedbacks.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Feedback $feedback): View
    {
        $this->authorize('update', $feedback);

        return view('app.feedbacks.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FeedbackUpdateRequest $request,
        Feedback $feedback
    ): RedirectResponse {
        $this->authorize('update', $feedback);

        $validated = $request->validated();

        $feedback->update($validated);

        return redirect()
            ->route('feedbacks.edit', $feedback)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Feedback $feedback
    ): RedirectResponse {
        $this->authorize('delete', $feedback);

        $feedback->delete();

        return redirect()
            ->route('feedbacks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
