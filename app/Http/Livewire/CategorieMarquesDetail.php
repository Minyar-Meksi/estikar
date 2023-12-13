<?php

namespace App\Http\Livewire;

use App\Models\Marque;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\Categorie;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategorieMarquesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Categorie $categorie;
    public Marque $marque;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Marque';

    protected $rules = [
        'marque.name' => ['required', 'max:255', 'string'],
    ];

    public function mount(Categorie $categorie): void
    {
        $this->categorie = $categorie;
        $this->resetMarqueData();
    }

    public function resetMarqueData(): void
    {
        $this->marque = new Marque();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMarque(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.categorie_marques.new_title');
        $this->resetMarqueData();

        $this->showModal();
    }

    public function editMarque(Marque $marque): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.categorie_marques.edit_title');
        $this->marque = $marque;

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

        if (!$this->marque->categorie_id) {
            $this->authorize('create', Marque::class);

            $this->marque->categorie_id = $this->categorie->id;
        } else {
            $this->authorize('update', $this->marque);
        }

        $this->marque->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Marque::class);

        Marque::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMarqueData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->categorie->marques as $marque) {
            array_push($this->selected, $marque->id);
        }
    }

    public function render(): View
    {
        return view('livewire.categorie-marques-detail', [
            'marques' => $this->categorie->marques()->paginate(20),
        ]);
    }
}
