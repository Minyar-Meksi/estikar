<?php

namespace App\Http\Livewire;

use App\Models\Option;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\SousOption;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OptionSousOptionsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Option $option;
    public SousOption $sousOption;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SousOption';

    protected $rules = [
        'sousOption.price' => ['required', 'numeric'],
        'sousOption.name' => ['required', 'max:255', 'string'],
    ];

    public function mount(Option $option): void
    {
        $this->option = $option;
        $this->resetSousOptionData();
    }

    public function resetSousOptionData(): void
    {
        $this->sousOption = new SousOption();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSousOption(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.option_sous_options.new_title');
        $this->resetSousOptionData();

        $this->showModal();
    }

    public function editSousOption(SousOption $sousOption): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.option_sous_options.edit_title');
        $this->sousOption = $sousOption;

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

        if (!$this->sousOption->option_id) {
            $this->authorize('create', SousOption::class);

            $this->sousOption->option_id = $this->option->id;
        } else {
            $this->authorize('update', $this->sousOption);
        }

        $this->sousOption->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SousOption::class);

        SousOption::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSousOptionData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->option->sousOptions as $sousOption) {
            array_push($this->selected, $sousOption->id);
        }
    }

    public function render(): View
    {
        return view('livewire.option-sous-options-detail', [
            'sousOptions' => $this->option->sousOptions()->paginate(20),
        ]);
    }
}
