@php $editing = isset($option) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $option->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="type" label="Type">
            @php $selected = old('type', ($editing ? $option->type : '')) @endphp
            <option value="checkbox" {{ $selected == 'checkbox' ? 'selected' : '' }} >Checkbox</option>
            <option value="radiobox" {{ $selected == 'radiobox' ? 'selected' : '' }} >Radiobox</option>
            <option value="dropdown" {{ $selected == 'dropdown' ? 'selected' : '' }} >Dropdown</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
