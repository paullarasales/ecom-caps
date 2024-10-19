<x-app-layout>
    
    <div class="min-h-screen">
        <main class="pt-8 mx-5 pb-16 lg:mt-4 lg:pt-16 lg:pb-24 bg-white antialiased">
            <div class="text-center">
                <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-80 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                    Notifications
                </h2>
            </div>
            
            {{-- APPOINTMENTS --}}
            @if($appointments->isNotEmpty())
            <div class="lg:mx-32 my-10">
                @foreach($appointments as $appointment)
                    @if($appointment->status === 'pending')
                    <h1 class="text-md text-gray-600 py-4">
                        Your request has already been submitted. Please arrive on the meeting date 
                        {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y g:i A') }}.
                    </h1>                    
                    @elseif($appointment->status === 'booked')
                        <h1 class="text-md text-gray-600 py-4">Your event {{ $appointment->type }} on {{ $appointment->edate }} is already booked.</h1>
                    @elseif($appointment->status === 'done')
                        <h1 class="text-md text-gray-600 py-4">
                            Your event {{ $appointment->type }} on {{ $appointment->edate }} is done.
                            @if(is_null($appointment->review))
                                <a href="{{ route('makereviews', $appointment->appointment_id) }}" class="text-blue-500 underline">Make a review</a>
                            @else
                                <span class="text-green-500">Review already submitted</span>
                            @endif
                        </h1>
                    @elseif($appointment->status === 'cancelled')
                        <h1 class="text-md text-gray-600 py-4">Your event {{ $appointment->type }} on {{ $appointment->edate }} has been cancelled.</h1>
                    @endif
                    <hr>
                @endforeach
            </div>
            @else
            <div class="lg:mx-32 my-10">
                <h1 class="text-md text-gray-600 py-4">You have no appointments.</h1>
            </div>
            @endif


            {{-- VERIFYSTATUS --}}
            @if($isVerified)
                <div class="lg:mx-32 my-10 bg-green-50 text-gray-600 p-4 rounded-lg">
                    <h1 class="text-md font-semibold">You have already been verified.</h1>
                </div>
            @else
                <div class="lg:mx-32 my-10 bg-yellow-50 text-gray-600 p-4 rounded-lg">
                    <h1 class="text-md font-semibold">Your verification is still pending.</h1>
                </div>
            @endif

            {{-- Check if user has submitted personal details --}}
            @if($hasPersonalDetails)
                <div class="lg:mx-32 my-10 bg-green-50 text-gray-600 p-4 rounded-lg">
                    <h1 class="text-md font-semibold">You have submitted your personal details, waiting for verification.</h1>
                </div>
            @else
                <div class="lg:mx-32 my-10 bg-red-100 text-red-800 p-4 rounded-lg">
                    <h1 class="text-md font-semibold">Please complete your personal details for verification.</h1>
                </div>
            @endif
        </main>
    </div>
</x-app-layout>