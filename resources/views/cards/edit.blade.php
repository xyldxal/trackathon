<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-4">
            <a href="{{ route('boards.index') }}" class="text-blue-500">Boards</a>
            &raquo;
            <a href="{{ route('boards.show', $board) }}" class="text-blue-500">{{ $board->name }}</a>
            &raquo;
            <span class="text-gray-600">Edit Card</span>
        </nav>

        <h1 class="text-2xl font-bold mb-6">Edit Card</h1>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('cards.update', $card) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $card->title) }}"
                       class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">{{ old('description', $card->description) }}</textarea>
            </div>

            <!-- Due Date -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Due Date</label>
                <input type="datetime-local" name="due_date"
                       value="{{ old('due_date', $card->due_date ? $card->due_date->format('Y-m-d\TH:i') : '') }}"
                       class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- File Attachments -->
            <div class="mb-6">
                <h3 class="font-bold mb-2">Attachments</h3>
                @if($card->files->count() > 0)
                    <div class="space-y-2">
                        @foreach($card->files as $file)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <a href="{{ Storage::url($file->file_path) }}" 
                                   target="_blank"
                                   class="text-blue-500 hover:underline">
                                    <i class="fas fa-paperclip mr-2"></i>
                                    {{ $file->original_name }}
                                </a>
                                <form action="{{ route('files.destroy', $file) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700"
                                            onclick="return confirm('Delete this file?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No attachments</p>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('boards.show', $board) }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Add File Form -->
        <div class="mt-8">
            <h3 class="text-xl font-bold mb-4">Add Attachment</h3>
            <form action="{{ route('cards.attachFile', $card) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center space-x-4">
                    <input type="file" name="file" class="flex-1" required>
                    <button type="submit" 
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>