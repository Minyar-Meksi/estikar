@php $editing = isset($marque) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $marque->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="categorie_id" label="Categorie" required>
            @php $selected = old('categorie_id', ($editing ? $marque->categorie_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Categorie</option>
            @foreach($categories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
