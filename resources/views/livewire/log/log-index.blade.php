<div class="wrapper">
    @livewire('navbar')
    @livewire('side-bar')
    <div class="content-wrapper">
        @push('styles')
            <style>
                .c-pointer {
                    cursor: pointer;
                }
            </style>
        @endpush
        <div class="content-header">
            @livewire('partial.breadcrumb',
                [
                    'page' => 'Adverts',
                    'links' => [
                        ['title' => 'Home', 'route' => 'admin.dashboard', 'active' => 0],
                        ['title' => 'Log', 'route' => 'log', 'active' => 1],
                    ]
                ])
            <div class="col-md-12">
                <div class="card p-0">
                <div class="row card-header d-flex justify-content-between">
                    <div class="col-md-3 mt-4">
                        <button type="button" class="btn btn-primary btn-sm" wire:click="EmitPrint">
                           <i class="fas fa-file-pdf"></i> Generate PDF
                           <i class="fas fa-sync-alt fa-spin" wire:loading wire:target="EmitPrint"></i>
                        </button>
                        <hr class=" d-lg-none d-md-none">
                        {{-- <button wire:click="downloadMediaOrder">Download</button> --}}
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>From -> </label>
                            <input type="date" class="form-control" placeholder="From date" wire:model='dateFrom'>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>To <- </label>
                            <input type="date" class="form-control" placeholder="To date" wire:model='dateTo'>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Name/Title</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" wire:model="searchText">
                            <span class="input-group-append">
                              <button type="button" class="btn btn-default" wire:click="search">
                                  <i class="fas fa-search" wire:loading.hide wire:target="EmitPrint"></i>
                                  <i class="fas fa-sync-alt fa-spin" wire:loading wire:target="EmitPrint"></i>
                              </button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0 overflow-auto" style="max-height:72vh; overflow-x: auto;">
                    {{-- <div class="overlay dark" wire:loading>
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    </div> --}}
                    <table class="table table-striped table-inverse table-responsive table-bordered table-condensed table-hover">
                        <thead class="thead-inverse">
                            <tr>
                                <th>S/No</th>
                                <th>File / Addvert Name</th>
                                <th>Date Played</th>
                                <th>Time Played</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $log)
                                    <tr class="{{$log->file_id ? 'bg-info' : ''}}">
                                        <td class="py-1">{{ $key +1 }}</td>
                                        <td class="py-1">{{ $log->name }}</td>
                                        <td class="py-1">{{ $log->formatDatePlayed() }}</td>
                                        <td class="py-1">{{ $log->formatTimePlayed() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                    <div class="card-footer pb-0">
                        @if (!$searchResult)
                        {{ $logs->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}

<div class="modal fade" id="printModal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-1 px-3">
                <h4 class="modal-title p-0">Print</h4>
            </div>
            <div class="modal-body p-0">
                <div class="card-body">
                    <table class="table table-striped table-inverse table-responsive table-bordered table-condensed table-hover">
                        <thead class="thead-inverse">
                            <tr>
                                <th>S/No</th>
                                <th>File / Addvert Name</th>
                                <th>Date Played</th>
                                <th>Time Played</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $key => $log)
                                    <tr class="{{$log->file_id ? 'bg-info' : ''}}">
                                        <td class="py-1">{{ $key +1 }}</td>
                                        <td class="py-1">{{ $log->name }}</td>
                                        <td class="py-1">{{ $log->formatDatePlayed() }}</td>
                                        <td class="py-1">{{ $log->formatTimePlayed() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
