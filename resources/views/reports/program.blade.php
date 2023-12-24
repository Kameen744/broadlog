{{-- @include('reports.header') --}}
@extends('reports.main')
@if (isset($searchText) & !empty($searchText))
    @section('title')
        {{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
        - Schedule for  {{ $searchText }}
    @endsection
@else
    @section('title')
        {{ env('STATION_NAME') }} {{ env('STATION_LOCATION') }}
        - Programs Schedule
    @endsection
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
            <th>Program</th>
            <th>Description</th>
            <th>Schedule</th>
        </tr>
        @foreach ($programs as $key => $program)
        <tr class="item-row">
            <td>{{$key + 1}}</td>
            <td>{{ $program->program }}</td>
            <td>{{ $program->description}}</td>
            <td>
                @foreach ($program->schedule as $schedule)
                    <p>
                        {{ $schedule->day->day }} -
                        {{ $schedule->formatTimeFrom() }}
                        to {{ $schedule->formatTimeTo() }}
                    </p>
                @endforeach
            </td>
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
