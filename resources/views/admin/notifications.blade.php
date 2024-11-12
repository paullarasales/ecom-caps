<x-admin-layout>
    <div class="min-h-screen">
        <main class="pt-8 mx-5 pb-16 lg:mt-4 lg:pt-16 lg:pb-24 bg-white antialiased">
            <div class="text-center">
                <h2 class="font-heading mb-4 bg-yellow-100 text-orange-800 px-4 py-2 rounded-lg w-full sm:w-80 mx-auto text-xs font-semibold tracking-widest uppercase title-font">
                    Notifications
                </h2>
            </div>

            {{-- Users Waiting for Verification --}}
            @if($users->isNotEmpty())
            <div class="lg:mx-32 my-10">
                <h2 class="text-lg font-semibold mb-4">Verification</h2>
                @foreach($users as $user)
                    <h1 class="text-md text-gray-600 py-4">
                        A new user <span class="capitalize">{{ $user->firstname . ' ' . $user->lastname }}</span> is waiting for 
                        <a href="{{ route('verify.edit', $user->id) }}" class="text-yellow-600 underline">verification.</a>
                    </h1>
                    <hr>
                @endforeach
            </div>
            @else
            <div class="lg:mx-32 my-10">
                <h1 class="text-md text-gray-600 py-4">There are no users waiting for verification.</h1>
            </div>
            @endif
            

            {{-- Unread Appointments --}}
            @if($unreadAppointments->isNotEmpty())
                <div class="lg:mx-32 my-10">
                    <h2 class="text-lg font-semibold mb-4">Appointments</h2>
                    <hr>
                    @foreach($unreadAppointments as $appointment)
                        @if ($appointment->user && $appointment->status === 'pending') {{-- Ensure the appointment has a related user --}}
                            <h1 class="text-md text-gray-600 py-4">
                                <span class="capitalize">{{ $appointment->user->firstname . ' ' . $appointment->user->lastname }}</span> made a request.
                                <a href="{{route('pendingView', $appointment->appointment_id)}}" class="text-yellow-600 underline">View Request</a>
                            </h1>
                            <hr>
                        @elseif ($appointment->user && $appointment->status === 'mcancelled' && \Carbon\Carbon::parse($appointment->edate)->isFuture()) {{-- Ensure the appointment has a related user --}}
                            <h1 class="text-md text-gray-600 py-4">
                                Meeting with <span class="capitalize">{{ $appointment->user->firstname . ' ' . $appointment->user->lastname }}</span> 
                                on {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y g:i A') }} 
                                for the event {{$appointment->type}} on {{ \Carbon\Carbon::parse($appointment->edate)->format('F j, Y') }} has been cancelled
                            </h1>
                            <hr>
                        @elseif (!$appointment->location && $appointment->status === 'mcancelled' && \Carbon\Carbon::parse($appointment->appointment_datetime)->isFuture())
                            {{-- Handle case where appointment does not have an associated user --}}
                            <h1 class="text-md text-gray-600 py-4">
                                Meeting with <span class="capitalize">{{ $appointment->user->firstname . ' ' . $appointment->user->lastname }}</span>
                                on {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y g:i A') }} has been canceled.
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
</x-admin-layout>
