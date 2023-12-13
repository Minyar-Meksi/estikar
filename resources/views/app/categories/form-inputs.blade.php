@php $editing = isset($categorie) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $categorie->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
