@php $editing = isset($modele) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $modele->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="marque_id" label="Marque" required>
            @php $selected = old('marque_id', ($editing ? $modele->marque_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Marque</option>
            @foreach($marques as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
