<x-app-layout>


    <div class="text-center py-2 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            View <span class="text-yellow-600">Package</span>
        </h3>
    </div>

    <div class="flex justify-center">
        <div class="flex flex-col items-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-3xl dark:border-gray-700 dark:bg-gray-200 ">
            @if ($package->packagephoto)
                <img class="object-cover w-full cursor-pointer max-w-sm h-48 md:w-48 md:h-full rounded-t-lg md:rounded-none md:rounded-s-lg" src="{{ asset($package->packagephoto) }}" alt="Package Image" onclick="openModal('{{ asset($package->packagephoto) }}')">
            @endif
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl uppercase font-bold tracking-tight text-gray-700">{{ $package->packagename }}</h5>
                <p class="mb-3 text-xl font-normal uppercase text-gray-700">₱ {{ number_format($package->packagedesc, 2) }}</p>

                <p class="mb-3 text-xl font-normal uppercase text-gray-700">Sample Photos</p>
                @if ($package->packagetype === 'Normal')
                    @if ($samplePhotos && count($samplePhotos) > 0)
                        <!-- Display the sample photos if they exist -->
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 ">
                            @foreach ($samplePhotos as $photo)
                                <div class="relative overflow-hidden w-48 h-48 sm:w-32 sm:h-32" >
                                    <img src="{{ asset($photo) }}" alt="Sample Photos" class="absolute inset-0 w-full h-full object-cover cursor-pointer" 
                                        onclick="openModal('{{ asset($photo) }}')"/>
                                </div>
                            @endforeach
                        </div>
                    @endif
                
                @endif
                
            </div>
        </div>
    </div>

    <section class="my-10 lg:my-10">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-1/3 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                        We can also customize your package
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden bg-gray-800 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative max-w-md max-h-[75vh] bg-white rounded-lg shadow-lg">
                <button class="absolute top-0 right-0 m-4 text-white" onclick="closeModal()">
                    <i class="fa-solid text-black fa-xmark text-3xl"></i>
                </button>
                <div id="modal-content" class="border rounded-lg border-gray-700"></div>
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

@if(session('alert'))
    <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-green-400 text-white rounded shadow-lg flex items-center space-x-2">
        <span>{{ session('alert') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white bg-green-600 hover:bg-green-700 rounded-full p-1">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
@elseif(session('error'))
    <div class="fixed top-0 right-0 mt-4 mr-4 px-4 py-2 bg-red-400 text-white rounded shadow-lg flex items-center space-x-2">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white bg-red-600 hover:bg-red-700 rounded-full p-1">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
@endif
</x-app-layout>
