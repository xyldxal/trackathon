<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardList extends Model
{
    protected $fillable = ['title', 'position'];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class)->orderBy('position');
    }
}
