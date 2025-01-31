<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\BoardList;

class BoardListController extends Controller
{
    public function store(Request $request, Board $board){
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $board->boardLists()->create([
            'title' => $request->title,
            'position' => $board->lists->count() + 1
        ]);

        return redirect()->back();
    }

    public function updatePosition(Request $request, Board $board){
        foreach($request->input('lists') as $listData){
            BoardList::where('id', $listData['id'])->update(
                [
                    'position' => $listData['position']
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function reorder(Request $request, Board $board)
    {
        $request->validate([
            'lists' => 'required|array',
            'lists.*.id' => 'required|exists:board_lists,id',
            'lists.*.position' => 'required|integer'
        ]);
    
        foreach ($request->lists as $list) {
            $board->boardLists()
                ->where('id', $list['id'])
                ->update(['position' => $list['position']]);
        }
    
        return response()->json(['status' => 'success']);
    }

    public function destroy(BoardList $list)
    {
        $list->cards()->delete();
        $list->delete();

        return redirect()->back()->with('success', 'List deleted successfully');
    }
}
