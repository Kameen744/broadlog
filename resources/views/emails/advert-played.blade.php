@component('mail::message')
# Broad Media

Notification for <b>{{$name}}</b> campaign
<p>Total Slots: <b>{{$slots}}</b></p>
<p>Total Played: <b>{{$total_played}}</b></p>
<p>Date Played: <b>{{$date_played}}</b></p>
<p>Time Played: <b>{{$time_played}}</b></p>
<p>Remaining: <b>{{$slots - $total_played}}</b></p>
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
