<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\BoardList;
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

        return redirect()->back();
    }

    public function update(Request $request, Card $card){
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $card->update($request->all());

        if ($request->has('due_date')){
            (new CalendarSyncService())->syncCardToCalendar($card);
        }

        return redirect()->back();
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

        return response()->json(['success' => true]);
    }

    public function attachFile(Request $request, Card $card){
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $file = $request->file('file');
        $path = $file->store('attachments', 'local');

        $card->files()->create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName()
        ]);

        return redirecf()->back();
    }

    public function destroy(Card $card){
        $card->delete();
        return redirect()->back();
    }
}
