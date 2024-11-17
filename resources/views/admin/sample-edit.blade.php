<x-admin-layout>

    <div class="absolute">
        <a href="javascript:window.history.back();">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Sample Photos</span>
        </h3>

    </div>

    @if ($errors->any())
    <ul class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

<form action="{{route('updatesample', $sample->sample_id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method("PUT")
<div class="p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Sample Photos</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            <input type="hidden" name="sample_id" value="{{ $sample->sample_id }}">

                            <div class="md:col-span-5">
                                <label for="age">Images</label>
                                <input type="file" name="sampleimages[]" id="images" class="h-10 border py-2 mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" accept="image/*" multiple onchange="limitFiles(this, 4)"/>
                                <script>
                                    function limitFiles(input, maxFiles) {
                                        if (input.files.length > maxFiles) {
                                            alert("You can only select a maximum of " + maxFiles + " files.");
                                            input.value = ''; // Clear the selected files
                                        }
                                    }
                                    </script>
                            </div>

                            <div class="md:col-span-5 text-right">
                                <input type="submit" name="submit" value="Submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
    
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
</x-admin-layout>
    
