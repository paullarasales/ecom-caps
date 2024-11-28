<x-admin-layout>

    <div class="absolute">
        <a href="{{route('viewpost')}}">
            <i class="fa-solid fa-arrow-left float-left ml-5 text-xl"></i>
        </a>
    </div>

    <div class="text-center py-2 my-2">
                
        <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
            Edit <span class="text-yellow-600">Post</span>
        </h3>

    </div>

    @if ($errors->any())
    <ul class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

<form action="{{route('updatepost', $post->post_id)}}" method="POST" enctype="multipart/form-data">
    @method("PUT")
    @csrf
<div class="p-6 flex items-center justify-center">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg shadow-yellow-100 p-4 px-4 md:p-8 mb-6">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Edit Post</p>
                            <p>Please fill out all the fields.</p>
                        </div>

                    <div class="lg:col-span-2">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-5">
                                <label for="firstname">Description</label>
                                <input type="text" name="description" id="description" class="h-10 border py-10 mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" maxlength="220" value="{{$post->postdesc}}" />
                                <script>
                                    document.getElementById("description").addEventListener("input", function() {
                                        if (this.value.length > 220) {
                                            this.value = this.value.slice(0, 220);
                                        }
                                    });
                                
                                    document.getElementById("description").addEventListener("change", function() {
                                        if (this.value.length < 220) {
                                            let remainingSpace = 220 - this.value.length;
                                            this.value += ' '.repeat(remainingSpace);
                                        }
                                    });
                                    </script>
                            </div>

                            <div class="md:col-span-5">
                                <label for="age">Images</label>
                                <input type="file" name="images[]" id="images" class="h-10 border py-2 mt-1 rounded px-4 w-full bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring-yellow-500 focus:ring-1" accept="image/*" multiple onchange="limitFiles(this, 4)"/>
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
    
</x-admin-layout>
    
