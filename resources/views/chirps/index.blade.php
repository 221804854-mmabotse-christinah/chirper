<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        @session('sucess')
        <div x-data="{ isOpen: true }" x-show="isOpen" x-cloak
        class="relative flex flex-col sm:flex-row sm:items-center bg-gray-300
              dark:bg-cyan-700 shadow rounded-md py-5 pl-6 pr-8 sm:pr-6 mb-3 mt-3">
       <div class="flex flex-row items-center border-b sm:border-b-0 w-full
                   sm:auto pb-4 sm:pb-0">
           <div class="text-green-300" dark:text-gary-500>
               <svg class="w-6 sm:w-5 h-6 sm:h-5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                   <path stroke-linecap="round" stroke-linejoin="round"
                         stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                   </path>
               </svg>
           </div>
           <div class="text-sm font-medium ml-3 dark:text-gray-100">
               Success!.
           </div>
       </div>
       <div class="text-sm tracking-wide text-gray-500
           dark:text-white mt-4 sm:mt-0 sm:ml-4">{{ $value }}</div>
       <div @click="isOpen = false" class="absolute sm:relative sm:top-auto
                   sm:right-auto ml-auto right-4 top-4 text-gray-400 hover:text-gray-800
                   cursor-pointer">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M6 18L18 6M6 6l12 12"></path>
           </svg>
       </div>
   </div>
        @endsession
        
        <form id="chirpForm" method="POST" action="{{ route('chirps.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Trix editor for rich text -->
            <div class="mt-4">
                <input id="x" type="hidden" name="message">
                <trix-editor input="x" class="bg-white border-cyan-500 border" placeholder="What's on your mind...."></trix-editor>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>
        
            <!-- Submit button -->
            <button type="button" onclick="submitForm()" class="mt-4 px-4 py-2 bg-cyan-500 text-white rounded-md shadow-md hover:bg-cyan-600 focus:outline-none focus:ring focus:ring-cyan-400">
                {{ __('Post') }}
            </button>
        </form>
        
        <script>
            function submitForm() {
                console.log("Form submitted");
        
                // Get the content from the Trix editor
                var content = document.querySelector('trix-editor').editor.getDocument().toString();
                console.log("Content:", content); // Check if the content is retrieved correctly
        
                // Update the value of the hidden input field with the content
                document.getElementById('x').value = content;
        
                // Submit the form
                document.getElementById('chirpForm').submit();
            }
        
            document.addEventListener("trix-attachment-add", function(event) {
                if (event.attachment.file) {
                    uploadFile(event.attachment);
                }
            });
        
            function uploadFile(attachment) {
                var file = attachment.file;
                var form = new FormData();
                form.append("image", file);
        
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('chirps.upload') }}", true);
                xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        
                xhr.upload.onprogress = function(event) {
                    var progress = event.loaded / event.total * 100;
                    attachment.setUploadProgress(progress);
                };
        
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        attachment.setAttributes({
                            url: response.url,
                            href: response.url
                        });
                    } else {
                        console.error("Upload failed: " + xhr.responseText);
                    }
                };
        
                xhr.onerror = function() {
                    console.error("Upload failed");
                };
        
                xhr.send(form);
            }
        </script>
        
        
        
        <div class="mt-6 mb4 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-cyan-400">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 dark:text-gray-100">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600 dark:text-gray-100">{{ $chirp->created_at->diffForHumans() }}</small>

                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600 dark:text-gray-100"> &middot; {{ __('edited') }}</small>
                                @endunless

                            </div>


                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>

                                    </x-slot>
                                </x-dropdown>
                            @endif
                            
                        </div>
                        <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $chirp->message }}</p>



                        @if ($chirp->image_path)
                            <img src="{{ asset($chirp->image_path) }}" alt="Chirp Image">
                        @endif


                        <!-- Comment Section -->
                        <div class="mt-4">
                            <form method="POST" action="{{ route('comments.store', $chirp) }}">
                                @csrf
                                <textarea
                                    name="body"
                                    placeholder="{{ __('Add a comment...') }}"
                                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                >{{ old('body') }}</textarea>
                                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                                <x-primary-button class="mt-4">{{ __('Comment') }}</x-primary-button>
                            </form>

                            <div class="mt-6 space-y-4">
                                @foreach($chirp->comments as $comment)
                                    <div class="flex space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="text-gray-800 dark:text-gray-100">{{ $comment->user->name }}</span>
                                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-100">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                @if ($comment->user->is(auth()->user()))
                                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-primary-button onclick="event.preventDefault(); this.closest('form').submit();">
                                                            {{ __('Delete') }}
                                                        </x-primary-button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Comment Section -->


                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{$chirps->links()}}
</x-app-layout>