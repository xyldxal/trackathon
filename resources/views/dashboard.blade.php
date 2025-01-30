<x-app-layout>
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
        <a href="{{ route('boards.create') }}" 
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + New Board
        </a>
    </div>

    <!-- Recent Boards -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Your Boards</h2>
        @include('partials.board-grid', ['boards' => $recentBoards])
    </div>

    <!-- Upcoming Deadlines & Files -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Deadlines -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Upcoming Deadlines</h2>
            @forelse ($upcomingEvents as $event)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                    <div>
                        <a href="{{ route('cards.show', $event->card) }}" class="text-blue-500">
                            {{ $event->title }}
                        </a>
                        <p class="text-sm text-gray-500">{{ $event->event_date->format('M j, Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No upcoming deadlines!</p>
            @endforelse
        </div>

        <!-- Recent Files -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Recent Files</h2>
            @forelse ($recentFiles as $file)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded">
                    <a href="{{ Storage::url($file->file_path) }}" class="text-blue-500">
                        <i class="fas fa-paperclip mr-2"></i>{{ $file->original_name }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No recent files!</p>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>
