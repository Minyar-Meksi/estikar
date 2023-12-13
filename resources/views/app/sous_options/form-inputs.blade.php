@php $editing = isset($sousOption) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="option_id" label="Option" required>
            @php $selected = old('option_id', ($editing ? $sousOption->option_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Option</option>
            @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $sousOption->price : ''))"
            step="1"
            placeholder="Price"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $sousOption->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
