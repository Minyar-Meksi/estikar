@php $editing = isset($feedback) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.textarea name="message" label="Message" required
            >{{ old('message', ($editing ? $feedback->message : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="rating"
            label="Rating"
            :value="old('rating', ($editing ? $feedback->rating : ''))"
            max="5"
            step="1"
            placeholder="Rating"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
