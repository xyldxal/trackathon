<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Create New Board</h1>
        
        <form action="{{ route('boards.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Board Name</label>
                <input type="text" name="name" required 
                       class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('boards.index') }}" 
                   class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Create Board
                </button>
            </div>
        </form>
    </div>
</x-app-layout>