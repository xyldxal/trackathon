<x-app-layout>
    <div class="mb-4">
        <h1 class="text-2xl font-bold">{{ $board->name }}</h1>
        <a href="{{ route('boards.index') }}" class="text-blue-500">← Back to Boards</a>
    </div>

    <!-- Lists Container -->
    <div class="flex gap-4 overflow-x-auto pb-4" id="board-lists">
        @foreach ($board->lists as $list)
        <!-- ... rest of your existing list/card HTML ... -->
        @endforeach

        <!-- Add List Form -->
        <div class="bg-gray-100 p-4 rounded min-w-[300px]">
            <form action="{{ route('lists.store', $board) }}" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Add a list" class="w-full p-1 border rounded">
                <button class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">Create List</button>
            </form>
        </div>
    </div>

<!-- Drag-and-Drop Script -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize drag-and-drop for cards
    document.querySelectorAll('.cards').forEach(list => {
        new Sortable(list, {
            group: 'shared',
            animation: 150,
            onEnd: (evt) => {
                const cardId = evt.item.dataset.cardId;
                const newListId = evt.to.dataset.listId;
                const position = Array.from(evt.to.children).indexOf(evt.item);

                fetch(`/cards/${cardId}/move`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        list_id: newListId,
                        position: position
                    })
                });
            }
        });
    });
</script>
@endpush
</x-app-layout>