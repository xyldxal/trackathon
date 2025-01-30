<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    public function index(){
        $boards = auth()->user()->boards()->with('lists.cards')->get();
        return view('boards.index', compact('boards'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $board = auth()->user()->boards()->create($request->only('name'));
        return redirect()->route('boards.show', $board);
    }

    public function create()
    {
        return view('boards.create'); 
    }

    public function show(Board $board){
        $board->load('lists.cards.files');
        return view('boards.show', compact('board'));
    }

    public function update(Request $request, Board $board){
        $request -> validate(
            [
                'name' => 'required|string|max:255'
            ]);
        $board->update($request->only('name'));
        return  redirect()->back();
    }

    public function destroy(Board $board){
        $board->delete();
        return redirect()->route('boards.index');
    }
}
