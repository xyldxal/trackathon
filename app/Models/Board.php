<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Board extends Model
{
    protected $fillable = ['name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lists(): HasMany
    {
        return $this->hasMany(BoardList::class);
    }

    public function boardLists(): HasMany
    {
        return $this->hasMany(BoardList::class);
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(
            Card::class, 
            BoardList::class,
            'board_id', // Foreign key on board_lists table
            'board_list_id' // Foreign key on cards table
        );
    }
}