<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    protected $fillable = ['title', 'description', 'due_date', 'position'];

    public function boardList(): BelongsTo
    {
        return $this->belongsTo(BoardList::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(FileAttachment::class);
    }

    public function calendarEvent(): HasOne
    {
        return $this->hasOne(CalendarEvent::class);
    }
}
