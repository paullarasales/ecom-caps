<div class="text-gray-800 mt-10 lg:mt-44 lg:mb-60 max-w-lg mx-auto lg:ml-40">
    <h1 class="text-3xl lg:text-6xl font-semibold leading-normal text-center lg:text-left">Your Account is not verified</h1>
    <p class="text-center lg:text-left lg:mt-4">Verify first before you can make request</p>
    <div class="mt-6 lg:mt-10 text-center lg:text-left">
        <a href="{{ route('personal', ['id' => auth()->user()->id]) }}" class="bg-yellow-200 rounded-3xl py-3 px-8 font-medium inline-block mr-4 hover:bg-transparent hover:border-yellow-500 hover:bg-yellow-400 duration-300 hover:border border border-t">Verify</a>
    </div>
</div>
