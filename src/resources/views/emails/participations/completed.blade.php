You participated the event !!<br><br>

Participation Detail:<br><br>

Event: {{ $event->title }}<br>
Place: {{ $event->place }}<br>
Fee: {{ $event->fee }}<br>
Date: {{ $event->date }}<br>
Description: {{ $event->description }}<br><br>

Check the participation Below<br>
{{ config('app.url') }}/participations/{{ $participation->id }}<br><br>

Thanks,<br>
{{ config('app.name') }}