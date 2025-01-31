<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileAttachment extends Model
{
    protected $fillable = ['card_id','file_path', 'original_name'];
    protected $casts = ['file_path' => 'string'];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
