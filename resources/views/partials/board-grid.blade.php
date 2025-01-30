<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse ($boards as $board)
        <a href="{{ route('boards.show', $board) }}" 
           class="group relative bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
            {{-- Board Content --}}
            <div class="space-y-2">
                {{-- Board Title --}}
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                    {{ $board->name }}
                </h3>
                
                {{-- Board Stats --}}
                <div class="flex items-center">
                    <i class="fas fa-list-ul mr-2 text-blue-500"></i>
                    {{ $board->boardLists->count() }} lists
                </div>
                <div class="flex items-center">
                    <i class="fas fa-tasks mr-2 text-green-500"></i>
                    {{ $board->cards->count() }} tasks
                </div>
                
                {{-- Recent Activity --}}
                @if($board->updated_at)
                    <p class="text-xs text-gray-500 mt-2">
                        Last updated {{ $board->updated_at->diffForHumans() }}
                    </p>
                @endif
            </div>
            
            {{-- Hover Overlay --}}
            <div class="absolute inset-0 bg-blue-500 bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg">
            </div>
        </a>
    @empty
        {{-- Empty State --}}
        <div class="col-span-full text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-clipboard-list text-4xl"></i>
            </div>
            <p class="text-gray-600 mb-4">No boards found</p>
            <a href="{{ route('boards.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Create Your First Board
            </a>
        </div>
    @endforelse
</div>