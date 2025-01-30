<x-app-layout>
<div class="mb-4">
    <h1 class="text-2xl font-bold mb-4">Your Boards</h1>
    <form action="{{ route('boards.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="New board name" class="p-2 border rounded">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>

<div class="grid grid-cols-3 gap-4">
    @foreach ($boards as $board)
    <a href="{{ route('boards.show', $board) }}" class="bg-white p-4 rounded shadow hover:shadow-lg transition">
        <h3 class="font-bold">{{ $board->name }}</h3>
        <p class="text-gray-600">{{ $board->lists->count() }} lists</p>
    </a>
    @endforeach
</div>
</x-app-layout>