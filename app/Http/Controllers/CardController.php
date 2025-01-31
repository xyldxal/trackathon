<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\BoardList;
use App\Models\FileAttachment;
use App\Services\CalendarSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function store(Request $request, BoardList $list){
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $card = $list->cards()->create([
            'title' => $request->title,
            'position' => $list->cards()->count() + 1
        ]);

        return redirect()->back()->with('success', 'Card created!');
    }

    public function update(Request $request, Card $card){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);
    
        // Update card
        $card->update($validated);

        if ($request->has('due_date')){
            (new CalendarSyncService())->syncCardToCalendar($card);
        }

        return redirect()->route('boards.show', $card->boardList->board)
        ->with('success', 'Card updated successfully');
    }

    public function move(Request $request, Card $card){
        $request->validate([
            'list_id' => 'required|exists:board_lists,id',
            'position' => 'required|integer'
        ]);
    
        $card->update([
            'board_list_id' => $request->list_id,
            'position' => $request->position
        ]);
    
        Card::where('board_list_id', $request->list_id)
            ->where('id', '!=', $card->id)
            ->orderBy('position')
            ->get()
            ->each(function ($card, $index) {
                $card->update(['position' => $index + 1]);
            });
    
        return response()->json(['status' => 'success']);
    }

    public function attachFile(Request $request, Card $card)
    {
        $request->validate([
            'file' => 'required|file|max:2048'
        ]);
    
        $file = $request->file('file');
        $path = $file->store('attachments', 'local');
    
        if (!$path) {
            return redirect()->back()
                ->with('error', 'Failed to store file');
        }
    
        $card->files()->create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName()
        ]);
    
        return redirect()->back()
            ->with('success', 'File uploaded successfully');
    }

    public function edit(Card $card)
    {
        $card->load('boardList.board', 'files');
        $board = $card->boardList->board;

        return view('cards.edit', compact('card', 'board'));
    }

    public function destroy(Card $card)
    {
        $card->files()->delete();
        $card->delete();
        return redirect()->back()->with('success', 'Card deleted successfully');
    }
}
