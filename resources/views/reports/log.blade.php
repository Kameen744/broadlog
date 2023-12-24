{{-- @include('reports.header') --}}
@extends('reports.main')
@if (isset($searchText))
@if (isset($dateFrom))
@if (isset($dateTo))
@section('title')
{{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
- Log Report {{ $searchText }} From {{ $dateFrom }} To {{ $dateTo }}
@endsection
@else
@section('title')
{{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
- Log Report {{ $searchText }} on {{ $dateFrom }}
@endsection
@endif
@else
@section('title')
{{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }} - Log Report for {{ $searchText }}
@endsection
@endif
@else
@if (isset($dateFrom))
@if (isset($dateTo))
@section('title')
{{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
- Log Report From {{ $dateFrom }} To {{ $dateTo }}
@endsection
@else
@section('title')
{{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
- Log Report on {{ $dateFrom }}
@endsection
@endif
@endif
@endif

@section('reportcontent')
{{-- <div id="customer">
    <div id="customer-title">Widget Corp.c/o Steve Widget</div>
    <table id="meta">
        <tr>
            <td class="meta-head">Invoice #</td>
            <td><textarea>000123</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Date</td>
            <td><textarea id="date">December 15, 2009</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Amount Due</td>
            <td><div class="due">$875.00</div></td>
        </tr>
    </table>
</div> --}}
<table id="items">
    <tr>
        <th>S/No</th>
        <th>File/Addvert Name</th>
        <th>Date Played</th>
        <th>Time Played</th>
    </tr>
    @foreach ($logs as $key => $log)
    <tr class="item-row @isset ($log->file_id) advert-row @endisset">
        <td>{{$key + 1}}</td>
        <td>{{ $log->name }}</td>
        {{-- <td>{{ $log->formatDatePlayed() }}</td>
        <td>{{ $log->formatTimePlayed() }}</td> --}}
        <td>{{ $log->date_played}}</td>
        <td>{{ $log->time_played }}</td>
    </tr>
    @endforeach
</table>

<div id="terms">
    <h5>{{ env('COMPANY_NAME') }} {{ env('BRAND') }}</h5>
    {{-- <textarea>&copy {{ env('COMPANY_NAME') }}</textarea> --}}
</div>
@endsection
{{-- <div style="clear:both"></div> --}}

{{-- <div id="customer">
    <div id="customer-title">Widget Corp.c/o Steve Widget</div>
    <table id="meta">
        <tr>
            <td class="meta-head">Invoice #</td>
            <td><textarea>000123</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Date</td>
            <td><textarea id="date">December 15, 2009</textarea></td>
        </tr>
        <tr>
            <td class="meta-head">Amount Due</td>
            <td><div class="due">$875.00</div></td>
        </tr>
    </table>
</div> --}}


{{-- @include('reports.footer') --}}
