<x-admin-layout>

    <div class="absolute">
        <a href="{{route('adminpost')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Manage <span class="text-yellow-600">Posts</span>
        </h3>

    </div>

    <main class="pt-8 mx-5 pb-16 lg:pt-16 lg:pb-24 bg-white antialiased">
        <div class="flex justify-between px-4  mx-auto max-w-screen-xl border border-yellow-700">
            <article class="mx-auto w-full max-w-6xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                @foreach ($post as $pt)
                <div>
                    <p class="lead text-md mt-10">{{ $pt->postdesc }}</p>
                </div>
                    @if (is_array($pt->postimage))
                        <div class="mt-5">
                            <div class="flex flex-wrap -mx-2">
                                @foreach ($pt->postimage as $index => $image)
                                    <div class="w-1/2 md:w-1/3 lg:w-1/4 px-2 mb-4">
                                        <div class="relative overflow-hidden" style="padding-top: 100%;">
                                            <img src="{{ asset($image) }}" alt="Featured image" class="absolute inset-0 w-full h-full object-cover cursor-pointer"
                                                onclick="openModal('{{ asset($image) }}')">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="text-right mb-5">
                        <a href="{{route('editpost', $pt->post_id)}}" class="inline-flex w-16 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Edit
                            <i class="fa-regular fa-pen-to-square ml-3"></i>
                        </a>
                        <a href="{{route('destroypost', $pt->post_id)}}" class="inline-flex w-20 items-center px-2 py-1 text-xs cursor-pointer font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Delete
                            <i class="fa-solid fa-trash ml-3"></i>
                        </a>                
                    </div>
                    <hr class="my-8 border-t border-yellow-700"> <!-- Horizontal line after each blog -->
                @endforeach
            </article>
        </div>
    </main>
    
    <!-- Modal -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative max-w-sm max-h-[75vh] bg-white  rounded-lg shadow-lg">
                <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                    <i class="fa-solid text-black fa-xmark text-3xl"></i>
                </button>
                <div id="modal-content" class="border rounded-lg border-gray-700"></div>
            </div>
        </div>
    </div>
    
    
    
    </div>
    <script>
        function openModal(imageSrc) {
            var modal = document.getElementById('modal');
            var modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = '<img src="' + imageSrc + '" class="max-w-full max-h-full rounded-lg">';
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
    
            // Close modal when clicked anywhere outside of the modal content
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }
    
        function closeModal() {
            var modal = document.getElementById('modal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>

    
    
</x-admin-layout>
    
