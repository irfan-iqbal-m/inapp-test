<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import User data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div>
                <div id="error-message" class="bg-red-500 text-white p-4 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="import-form" action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" />
                        <button type="submit" id="import-button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('import-form').addEventListener('submit', function(event) {
            var button = document.getElementById('import-button');
            button.disabled = true;
            button.textContent = 'Importing...'; // Optional: Change button text to indicate that the import is in progress
        });
        setTimeout(() => {
            document.getElementById('success-message').style.display = 'none';
        }, 3000);
    </script>
</x-app-layout>