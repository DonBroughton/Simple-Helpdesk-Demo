<x-guest>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Helpdesk Support
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col gap-4 p-6 text-gray-900 dark:text-gray-100 text-center">
                    @auth()
                        <p class="text-lg">You are now logged in, please proceed to the:</p>

                        <a class="mt-2 mx-8 md:mx-32 px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out "
                           href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    @else
                        <p class="text-lg">In order to receive support you will be required to:</p>

                        <a class="mt-2 mx-8 md:mx-32 px-4 py-2 font-semibold rounded-md bg-blue-500 hover:bg-blue-700 text-white transition duration-300 ease-in-out "
                           href="{{ route('login') }}">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-guest>
