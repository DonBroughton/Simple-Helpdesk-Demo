<x-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="my-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight select-none">
                Viewing All Support Tickets
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
            @else
                <div data-name="placeholder-for-layout" class="opacity-0"></div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!$tickets->isEmpty())
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500" title="Your Support Ticket Number">#</th>
                                            @if(auth()->user()->is_admin)<th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">User</th>@endif
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Title</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Description</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Priority</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Status</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Created</th>
                                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $ticket->id }}</td>
                                            @if(auth()->user()->is_admin)<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $ticket->user->name }}</td>@endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200" title="{{ $ticket->title }}">{{ Str::of($ticket->title)->take(30) . ((Str::length($ticket->title) > 40) ? ' ...' : '') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200" title="{{ $ticket->description }}">{{ Str::of($ticket->description)->take(30) . ((Str::length($ticket->description) > 40) ? ' ...' : '') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800 dark:text-neutral-200"><span class="text-white bg-{{ $ticket->priority->color }} px-2 py-1 rounded-md">{{ $ticket->priority->name }}</span></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $ticket->is_open ? 'Open' : 'Closed' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200" title="{{ $ticket->created_at->format('m/d/Y H:i') }}">{{ $ticket->created_at->diffForHumans() }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <a href="{{ route('ticket.show', [$ticket]) }}"
                                                   type="button"
                                                   class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-500 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                                                   View Details
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($tickets->isEmpty())
                        <div>This system has no tickets to display.</div>
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
