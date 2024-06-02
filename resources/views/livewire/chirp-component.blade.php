<div>
    <form wire:submit.prevent="storeChirp">
        <textarea wire:model="message" placeholder="{{ __('What\'s on your mind?') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
        <x-input-error :messages="$errors->get('message')" class="mt-2" />

        <!-- Custom file input -->
        <div class="mt-2 flex items-center">
            <label for="image" class="inline-block text-white bg-cyan-500 py-2 px-3 rounded-md cursor-pointer">
                Choose File
            </label>
            <input type="file" name="image" id="image" class="hidden" onchange="updateFileName(this)">
            <span id="file-name" class="ml-2 text-white"></span>
        </div>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />

        <x-primary-button type="submit" class="mt-4">{{ __('Chirp') }}</x-primary-button>
    </form>
</div>

<script>
    function updateFileName(input) {
        var fileName = input.files[0].name;
        document.getElementById('file-name').textContent = fileName;
    }
</script>
