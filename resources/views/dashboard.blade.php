<x-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="my-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight select-none">
                Helpdesk Overview
            </h2>

            @if(session('status'))
            <div id="status" class="px-2 py-1 bg-green-700 text-white">
                {{ Session::get('status') }}
            </div>
            @endif

            @if(!auth()->user()->is_admin)
            <a title="Create New Support Ticket"
               class="px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out select-none"
               href="{{ route('ticket.create') }}">
                New Support Ticket
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    @if(auth()->user()->is_admin)
                        <p>User Is Admin Show All Tickets</p>
                    @else
                        <p>User Is NOT Admin</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('status'))
    @push('scripts')
        <script>
            function fadeOutMessage() {
                // Get the element by ID
                var element = document.getElementById('status');

                // Wait for 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    var opacity = 1;  // Initial opacity

                    // Fade out over 3 seconds (3000 milliseconds)
                    var fadeInterval = setInterval(function() {
                        if (opacity <= 0) {
                            clearInterval(fadeInterval);  // Stop the interval when fully faded
                            element.style.display = 'none';  // Optionally hide the element
                        } else {
                            opacity -= 0.02;  // Decrease opacity
                            element.style.opacity = opacity;  // Set the element's opacity
                        }
                    }, 30);  // Adjust this interval for smoother fade (30ms steps)

                }, 5000);  // Wait 5 seconds before starting fade
            }
            fadeOutMessage();
        </script>
    @endpush
    @endif
</x-app>