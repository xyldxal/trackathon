<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\CalendarEvent;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', [
            'recentBoards' => Board::where('user_id', $user->id)
                ->latest()
                ->take(3)
                ->get(),
            'upcomingEvents' => CalendarEvent::where('user_id', $user->id)
                ->where('event_date', '>', now())
                ->orderBy('event_date')
                ->take(5)
                ->get(),
            'recentFiles' => FileAttachment::whereHas('card', function ($query) use ($user) {
                $query->whereHas('boardList.board', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
            ->latest()
            ->take(5)
            ->get()
        ]);
    }
}
