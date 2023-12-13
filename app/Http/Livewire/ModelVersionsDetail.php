<?php

namespace App\Http\Livewire;

use App\Models\Modele;
use Livewire\Component;
use App\Models\Version;
use Illuminate\View\View;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ModelVersionsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Modele $modele;
    public Version $version;
    public $versionPicture;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Version';

    protected $rules = [
        'version.name' => ['required', 'max:255', 'string'],
        'versionPicture' => ['image', 'max:1024', 'nullable'],
        'version.year' => ['required', 'numeric'],
    ];

    public function mount(Modele $modele): void
    {
        $this->modele = $modele;
        $this->resetVersionData();
    }

    public function resetVersionData(): void
    {
        $this->version = new Version();

        $this->versionPicture = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newVersion(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.model_versions.new_title');
        $this->resetVersionData();

        $this->showModal();
    }

    public function editVersion(Version $version): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.model_versions.edit_title');
        $this->version = $version;

        $this->dispatchBrowserEvent('refresh');

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

        if (!$this->version->modele_id) {
            $this->authorize('create', Version::class);

            $this->version->modele_id = $this->modele->id;
        } else {
            $this->authorize('update', $this->version);
        }

        if ($this->versionPicture) {
            $this->version->picture = $this->versionPicture->store('public');
        }

        $this->version->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Version::class);

        collect($this->selected)->each(function (string $id) {
            $version = Version::findOrFail($id);

            if ($version->picture) {
                Storage::delete($version->picture);
            }

            $version->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetVersionData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->modele->versions as $version) {
            array_push($this->selected, $version->id);
        }
    }

    public function render(): View
    {
        return view('livewire.model-versions-detail', [
            'versions' => $this->modele->versions()->paginate(20),
        ]);
    }
}
