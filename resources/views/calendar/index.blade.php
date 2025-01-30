@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Calendar</h1>
    <div id="calendar"></div>
</div>

@push('scripts')
<!-- FullCalendar Dependencies -->
<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            eventClick: (info) => {
                window.location.href = info.event.url; // Navigate to card
            }
        });
        calendar.render();
    });
</script>
@endpush
@endsection