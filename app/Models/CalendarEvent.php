<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = ['event_date', 'title'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
