<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardList extends Model
{
    protected $fillable = ['board_id', 'title', 'position'];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class)->orderBy('position');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($list) {
            if (empty($list->position)) {
                $list->position = self::where('board_id', $list->board_id)->count() + 1;
            }
        });
    }
}
