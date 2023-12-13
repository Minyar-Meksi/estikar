<?php

namespace App\Http\Livewire;

use App\Models\Marque;
use App\Models\Modele;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MarqueModelsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Marque $marque;
    public Modele $modele;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Modele';

    protected $rules = [
        'model.name' => ['required', 'max:255', 'string'],
    ];

    public function mount(Marque $marque): void
    {
        $this->marque = $marque;
        $this->resetModeleData();
    }

    public function resetModeleData(): void
    {
        $this->modele = new Modele();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newModele(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.marque_models.new_title');
        $this->resetModeleData();

        $this->showModal();
    }

    public function editModele(Modele $modele): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.marque_models.edit_title');
        $this->modele = $modele;

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

        if (!$this->modele->marque_id) {
            $this->authorize('create', Modele::class);

            $this->modele->marque_id = $this->marque->id;
        } else {
            $this->authorize('update', $this->modele);
        }

        $this->modele->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Modele::class);

        Modele::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetModeleData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->marque->modeles as $modele) {
            array_push($this->selected, $modele->id);
        }
    }

    public function render(): View
    {
        return view('livewire.marque-models-detail', [
            'modeles' => $this->marque->modeles()->paginate(20),
        ]);
    }
}
