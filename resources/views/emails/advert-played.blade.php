@component('mail::message')
# Broad Media

{{env('STATION_NAME')}} {{env('STATION_LOCATION')}} notification for <b>{{$name}}</b> campaign
<p>Total Slots: <b>{{$slots}}</b> Played: <b>{{$total_played}}</b> Remaining: {{$slots - $total_played}}</p>
<p>Date Played: <b>{{$date_played}}</b></p>
<p>Time Played: <b>{{$time_played}}</b></p>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
