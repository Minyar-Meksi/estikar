@php $editing = isset($version) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $version->name : ''))"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="modele_id" label="Modele" required>
            @php $selected = old('modele_id', ($editing ? $version->modele_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Modele</option>
            @foreach($modeles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $version->picture ? \Storage::url($version->picture) : '' }}')"
        >
            <x-inputs.partials.label
                name="picture"
                label="Picture"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="picture"
                    id="picture"
                    @change="fileChosen"
                />
            </div>

            @error('picture') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="year"
            label="Year"
            :value="old('year', ($editing ? $version->year : ''))"
            min="1920"
            max="2025"
            step="1"
            placeholder="Year"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.options.name')
        </h4>

        <div class="py-2">
            @foreach ($options as $option)
            <div>
                <x-inputs.checkbox
                    id="option{{ $option->id }}"
                    name="options[]"
                    label="{{ ucfirst($option->name) }}"
                    value="{{ $option->id }}"
                    :checked="isset($version) ? $version->options()->where('id', $option->id)->exists() : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>
</div>
