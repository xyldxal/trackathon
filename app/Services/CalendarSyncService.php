<?php

namespace App\Services;

use App\Models\CalendarEvent;
use App\Models\Card;

class CalendarSyncService
{
    public function syncCardToCalendar(Card $card): void
    {
        if (!$card->due_date) {
            CalendarEvent::where('card_id', $card->id)->delete();
            return;
        }

        CalendarEvent::updateOrCreate(
            ['card_id' => $card->id],
            [
                'user_id' => $card->boardList->board->user_id,
                'title' => $card->title,
                'event_date' => $card->due_date,
            ]
        );
    }
}