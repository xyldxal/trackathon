<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }

    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class);
    }

    public function cards()
    {
        return $this->hasManyThrough(
            Card::class,
            Board::class,
            'user_id',
            'board_list_id',
            'id',
            'id'
        )->via('lists');
    }

    public function fileAttachments()
    {
        return $this->hasManyThrough(
            FileAttachment::class,
            Card::class,
            'board_list_id', // Foreign key on cards table
            'card_id', // Foreign key on file_attachments table
            'id', // Local key on users table (not directly used)
            'id' // Local key on cards table
        )->whereHas('card.boardList.board', fn($q) => $q->where('user_id', $this->id));
    }
}
