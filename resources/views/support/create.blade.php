<x-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="my-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight select-none">
                Log A New Support Ticket
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full lg:w-1/2">

                        <form class="flex flex-col gap-y-6 " method="POST" action="{{ route('ticket.store') }}">
                            @csrf
                            <div class="flex flex-col">
                                <label class="select-none" for="title">Title:<span class="text-red-500">*</span></label>
                                <input class="text-gray-800" name="title" id="title" type="text">
                            </div>
                            <div class="flex flex-col">
                                <label class="select-none" for="description">Please describe your support ticket in detail:<span class="text-red-500">*</span></label>
                                <textarea class="text-gray-800" id="description" name="description" rows="4" cols="50"></textarea>
                            </div>
                            <div class="flex flex-col">
                                <label class="select-none" for="priority">Priority:<span class="text-red-500">*</span></label>
                                <select class="text-gray-800" name="priority" id="priority">
                                    @foreach($priorities as $priority)
                                        <option value="{{ Str::lcfirst($priority->name) }}">{{ $priority->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="italic">Fields marked with an <span class="text-red-500">*</span> asterisk are required</p>
                            <div class="flex flex-col">
                                <button class="px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out select-none" type="submit" value="Submit">Create Ticket</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
