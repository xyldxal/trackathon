@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Card</h2>

    <form action="{{ route('cards.update', $card) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Title -->
        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" name="title" value="{{ $card->title }}" class="w-full p-2 border rounded">
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 border rounded">{{ $card->description }}</textarea>
        </div>

        <!-- Due Date -->
        <div class="mb-4">
            <label class="block text-gray-700">Due Date</label>
            <input type="datetime-local" name="due_date" value="{{ $card->due_date?->format('Y-m-d\TH:i') }}" class="p-2 border rounded">
        </div>

        <!-- Attachments -->
        <div class="mb-4">
            <h3 class="font-bold mb-2">Attachments</h3>
            @foreach ($card->files as $file)
            <div class="flex items-center justify-between mb-2">
                <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-blue-500">
                    <i class="fas fa-paperclip"></i> {{ $file->original_name }}
                </a>
                <button type="button" onclick="confirm('Delete file?') && document.getElementById('delete-file-{{ $file->id }}').submit()" class="text-red-500">
                    <i class="fas fa-trash"></i>
                </button>
                <form id="delete-file-{{ $file->id }}" action="{{ route('files.destroy', $file) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            @endforeach
        </div>

        <!-- File Upload -->
        <div class="mb-4">
            <form action="{{ route('cards.attachFile', $card) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="mb-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Upload File</button>
            </form>
        </div>

        <!-- Save Button -->
        <button class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
    </form>
</div>
@endsection