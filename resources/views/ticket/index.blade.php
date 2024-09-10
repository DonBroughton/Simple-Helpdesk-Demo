<x-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="my-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight select-none">
                Viewing All Support Tickets
            </h2>

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
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Priority</th>
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ Str::of($ticket->title)->take(40) . ((Str::length($ticket->title) > 40) ? ' ...' : '') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200" title="{{ $ticket->description }}">{{ Str::of($ticket->description)->take(40) . ((Str::length($ticket->description) > 40) ? ' ...' : '') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"><span class="text-white bg-{{ $ticket->priority->color }} px-2 py-1 rounded-md">{{ $ticket->priority->name }}</span></td>
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

                </div>
            </div>
        </div>
    </div>
</x-app>
