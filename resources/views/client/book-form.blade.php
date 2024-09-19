<x-app-layout>

    @if (Auth::check() && Auth::user()->verifystatus === 'unverified')
        
        
        @include('client.edit-verify')

    {{--  --}}

    @else

    @include('client.form')
    
    @endif

    @if(Session::has('alert'))
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ Session::get('alert') }}');
            });
        </script>
    @endif
</x-app-layout>