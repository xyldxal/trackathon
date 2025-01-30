<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\BoardList;

class BoardListController extends Controller
{
    public function store(Request $request, Board $board){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $board->lists()->create([
            'title' => $request->name,
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
}
