<x-app-layout>


    <div class="text-center py-2 my-20">
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            View <span class="text-yellow-600">Package</span>
        </h3>
    </div>

    <div class="flex justify-center">
        <div class="flex flex-col items-center text-center w-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-200">
            
            <!-- Package Info -->
            <div class="p-6 w-full">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-900">{{ $package->packagename }}</h2>
                <p class="text-xl font-bold text-gray-700 dark:text-gray-700 mt-2">Estimated Price: ₱{{ number_format($package->packagedesc, 2) }}</p>
                
                <!-- Package Inclusion Table -->
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-900">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-1/5">#</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 w-4/5">Inclusion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach (json_decode($package->packageinclusion) as $index => $inclusion)
                            <tr>
                                <td class="px-4 py-2 w-1/5">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 w-4/5">{{ $inclusion }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
    
        </div>
    </div>
    

    <section class="my-10 lg:my-10">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-1/3 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                        We will customize your preferred package when you arrive at on the meeting
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
