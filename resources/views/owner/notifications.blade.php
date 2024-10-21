<x-owner-layout>
    <div class="min-h-screen">
        <main class="pt-8 mx-5 pb-16 lg:mt-4 lg:pt-16 lg:pb-24 bg-white antialiased">
            <div class="text-center">
                <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-80 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                    Notifications
                </h2>
            </div>

            {{-- Users Waiting for Verification --}}
            {{-- @if($users->isNotEmpty())
            <div class="lg:mx-32 my-10">
                @foreach($users as $user)
                    <h1 class="text-md text-gray-600 py-4">
                        A new user <span class="capitalize">{{ $user->firstname . ' ' . $user->lastname }}</span> is waiting for 
                        <a href="{{ route('managerverify.edit', $user->id) }}" class="text-yellow-600 underline">verification.</a>
                    </h1>
                    <hr>
                @endforeach
            </div>
            @else
            <div class="lg:mx-32 my-10">
                <h1 class="text-md text-gray-600 py-4">There are no users waiting for verification.</h1>
            </div>
            @endif --}}
            

            {{-- Unread Appointments --}}
            @if($unreadAppointments->isNotEmpty())
                <div class="lg:mx-32 my-10">
                    <h2 class="text-lg font-semibold mb-4">Unread Appointments</h2>
                    @foreach($unreadAppointments as $appointment)
                        @if ($appointment->user) {{-- Ensure the appointment has a related user --}}
                            <h1 class="text-md text-gray-600 py-4">
                                <span class="capitalize">{{ $appointment->user->firstname . ' ' . $appointment->user->lastname }}</span> made a request.
                                
                            </h1>
                            <hr>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="lg:mx-32 my-10">
                    <h1 class="text-md text-gray-600 py-4">There are no unread appointments.</h1>
                </div>
            @endif

            
        </main>
    </div>
</x-owner-layout>
