<x-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="my-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight select-none">
                Ticket Details
            </h2>

            @if(session('status'))
            <div id="status" class="px-2 py-1 bg-green-700 text-white">
                {{ Session::get('status') }}
            </div>
            @endif

            <a title="Return To Tickets Overview"
               class="px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out select-none"
               href="{{ route('ticket.index') }}">
                Back To Tickets Overview
            </a>

        </div>
    </x-slot>

    <div class="pt-12 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold text-xl tracking-wider uppercase">Ticket Details</h4>
                    <div class="mt-6 flex flex-col gap-4">
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Ticket #:</div>
                            <div class="flex-[6]">{{ $ticket->id }}</div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Ticket Priority:</div>
                            <div class="flex-[6]"><span class="text-white px-2 py-1 rounded-md bg-{{ $ticket->priority->color }}">{{ $ticket->priority->name }}</span></div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Ticket Date:</div>
                            <div class="flex-[6]">{{$ticket->created_at->format('d/m/Y')}} ({{ $ticket->created_at->diffForHumans() }})</div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Title:</div>
                            <div class="flex-[6]">{{ $ticket->title }}</div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Description:</div>
                            <div class="flex-[6]">{{ $ticket->description }}</div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="flex-[1]">Ticket Status:</div>
                            <div class="flex-[6]">{{ $ticket->is_open ? 'Open' : 'Closed' }}</div>
                        </div>

                    </div>

                    @if ($ticket->is_open && auth()->user()->is_admin)
                    <form class="mt-6" method="POST"
                          action="{{ route('ticket.update', ['ticket' => $ticket->id, 'status' => false]) }}">
                        @csrf
                        @method('PATCH')
                        <input class="px-4 py-2 font-semibold rounded-md bg-orange-500 hover:bg-orange-700 text-white transition duration-300 ease-in-out select-none"
                               type="submit"
                               value="Mark Ticket Closed" />
                    </form>
                    @endif


                </div>
            </div>
            @if ($ticket->is_open)
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h4 class="font-semibold text-xl tracking-wider uppercase">Ticket Reply</h4>
                        <div class="mt-6">
                            <form method="POST" action="{{ route('ticket.reply.store', ['ticket' => $ticket->id]) }}">
                                @csrf
                                <div class="my-2">
                                    <label for="reply">Your Reply:</label>
                                    <textarea class="mt-2 text-gray-900 w-full" id="reply" name="reply" rows="4" required></textarea>
                                    @if ($errors->has('reply'))
                                        <span class="text-red-500">{{ $errors->first('reply') }}</span>
                                    @endif
                                </div>
                                <input class="mt-2 px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out select-none" type="submit" value="Send Reply" />
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @foreach($ticket->replies as $reply)
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex gap-4">
                        <div class="flex-[1]">
                            <div class="font-semibold">
                                {{ $reply->user->name }} replied:
                            </div>
                            <div title="{{ $reply->updated_at }}" class="italic">
                                {{ $reply->updated_at->diffForHumans() }}
                            </div>

                        </div>
                        <div class="flex-[4]">
                            {{ $reply->body }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

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
