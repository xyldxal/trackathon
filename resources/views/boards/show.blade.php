<x-app-layout>
    <div class="mb-4">
        <h1 class="text-2xl font-bold">{{ $board->name }}</h1>
        <a href="{{ route('boards.index') }}" class="text-blue-500">← Back to Boards</a>
    </div>

    <!-- Lists Container -->
    <div class="flex gap-4 overflow-x-auto pb-4" id="board-lists">
        @foreach ($board->boardLists as $list)
        <div class="bg-white p-4 rounded shadow min-w-[300px] list-container" data-list-id="{{ $list->id }}">                <!-- List Header -->
            <div class="flex justify-between items-center mb-2 list-header">
                <h3 class="font-bold">{{ $list->title }}</h3>
                    <!-- Delete List Form -->
                    <form action="{{ route('lists.destroy', $list) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-500 hover:text-red-700"
                                onclick="return confirm('Are you sure you want to delete this list and all its cards?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>

                <!-- Cards -->
                <div class="space-y-2 cards" data-list-id="{{ $list->id }}" data-position="{{ $list->position }}">
                    @foreach ($list->cards as $card)
                        <div class="bg-gray-50 p-2 rounded border cursor-move card" data-card-id="{{ $card->id }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                <div class="font-medium text-gray-800">{{ $card->title }}</div>
                                    @if($card->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $card->description }}</p>
                                    @endif

                                    @if($card->due_date)
                                    <div class="mt-2 text-xs text-blue-600">
                                        <i class="fas fa-clock"></i>
                                        Due {{ $card->due_date->format('M j, Y') }}
                                    </div>
                                    @endif

                                    @if($card->files->count() > 0)
                                    <div class="mt-2 space-y-1">
                                        @foreach($card->files as $file)
                                        <div class="flex items-center text-sm">
                                            <a href="{{ Storage::url($file->file_path) }}" 
                                            class="text-blue-500 hover:underline flex items-center"
                                            target="_blank">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                {{ $file->original_name }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Card Actions -->
                                <div class="flex items-center space-x-2 ml-2">
                                    <!-- Edit Button -->
                                    <button class="text-gray-400 hover:text-blue-500"
                                            onclick="window.location.href='{{ route('cards.edit', $card) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <!-- Delete Card Form -->
                                    <form action="{{ route('cards.destroy', $card) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-gray-400 hover:text-red-500"
                                                onclick="return confirm('Are you sure you want to delete this card?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Card Form (unchanged) -->
                <form class="mt-4" action="{{ route('cards.store', $list) }}" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Add a card" class="w-full p-1 border rounded">
                    <button class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">Add</button>
                </form>
            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // 1. List Drag-and-Drop (Horizontal)
        const boardLists = document.getElementById('board-lists');
        new Sortable(boardLists, {
            animation: 150,
            handle: '.list-header', // Only drag by header
            ghostClass: 'list-dragging',
            onEnd: async (evt) => {
                const lists = Array.from(boardLists.children).map((list, index) => ({
                    id: list.dataset.listId,
                    position: index + 1
                }));

                try {
                    const response = await fetch('{{ route('boards.reorderLists', $board) }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ lists })
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                } catch (error) {
                    console.error('List reorder failed:', error);
                    evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                }
            }
        });

        // 2. Card Drag-and-Drop (Vertical within lists)
        document.querySelectorAll('.cards').forEach(list => {
            new Sortable(list, {
                group: 'shared', // Keep your existing group name
                animation: 150,
                ghostClass: 'card-dragging',
                onEnd: async (evt) => {
                    const cardId = evt.item.dataset.cardId;
                    const newListId = evt.to.dataset.listId;
                    const position = evt.newIndex + 1;

                    try {
                        const response = await fetch(`/cards/${cardId}/move`, {
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

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                    } catch (error) {
                        console.error('Card move failed:', error);
                        evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                    }
                }
            });
        });
    });
    </script>
    @endpush

    <!-- Add these styles -->
    <style>
    .list-dragging {
        opacity: 0.5;
        transform: rotate(3deg);
    }

    .card-dragging {
        opacity: 0.5;
        transform: scale(0.98);
    }

    .list-header {
        cursor: grab;
    }

    .list-header:active {
        cursor: grabbing;
    }
    </style>
</x-app-layout>