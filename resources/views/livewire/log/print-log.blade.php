<div>
    @if ($logs)
    <div class="card-body">
        <table class="table table-striped table-inverse table-responsive table-bordered table-condensed table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>S/No</th>
                    <th>File / Addvert Name</th>
                    <th>Date Played</th>
                    {{-- <th>Time Played</th> --}}
                </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $key => $log)

                        <tr class="{{$log['file_id'] ? 'bg-info' : ''}}">
                            <td class="py-1">{{ $key +1 }}</td>
                            <td class="py-1">{{ $log['name'] }}</td>
                            <td class="py-1">{{ date('d/m/Y', strtotime($log['date_played'])) }}</td>
                            {{-- <td class="py-1">{{ $log->formatTimePlayed() }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
    @endif
</div>
