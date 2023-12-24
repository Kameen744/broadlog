@extends('reports.main')
@section('title')
    {{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }} - Advert Schedule  {{ $today }}
@endsection
@section('reportcontent')
    <table id="items">
        <tr>
            <th>S/No</th>
            <th>File / Advert Name</th>
            <th>Time</th>
        </tr>
        @foreach ($schedules as $key => $schedule)
            <tr>
                <td class="py-1">{{ $key +1 }}</td>
                <td class="py-1">{{ $schedule->file->name }}</td>
                <td class="py-1">{{ date('h:i A', strtotime($schedule->play_time)) }}</td>
            </tr>
        @endforeach
    </table>

    <div id="terms">
        <h5>{{ env('COMPANY_NAME') }} {{ env('BRAND') }}</h5>
        {{-- <textarea> &copy {{ env('COMPANY_NAME') }} </textarea> --}}
    </div>
@endsection
