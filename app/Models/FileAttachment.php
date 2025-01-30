<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileAttachment extends Model
{
    protected $fillable = ['file_path', 'original_name'];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
