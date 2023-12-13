<?php

namespace App\Http\Livewire;

use App\Models\Option;
use Livewire\Component;
use App\Models\Version;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OptionVersionsDetail extends Component
{
    use AuthorizesRequests;

    public Option $option;
    public Version $version;
    public $versionsForSelect = [];
    public $version_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Version';

    protected $rules = [
        'version_id' => ['required', 'exists:versions,id'],
    ];

    public function mount(Option $option): void
    {
        $this->option = $option;
        $this->versionsForSelect = Version::pluck('name', 'id');
        $this->resetVersionData();
    }

    public function resetVersionData(): void
    {
        $this->version = new Version();

        $this->version_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newVersion(): void
    {
        $this->modalTitle = trans('crud.option_versions.new_title');
        $this->resetVersionData();

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        $this->authorize('create', Version::class);

        $this->option->versions()->attach($this->version_id, []);

        $this->hideModal();
    }

    public function detach($version): void
    {
        $this->authorize('delete-any', Version::class);

        $this->option->versions()->detach($version);

        $this->resetVersionData();
    }

    public function render(): View
    {
        return view('livewire.option-versions-detail', [
            'optionVersions' => $this->option
                ->versions()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
