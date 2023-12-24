<div class="wrapper">
    @livewire('navbar')
    @livewire('side-bar')
    <div class="content-wrapper">
        <div class="content-header">
            @livewire('partial.breadcrumb',
                [
                    'page' => 'Programs',
                    'links' => [
                        ['title' => 'Home', 'route' => 'admin.dashboard', 'active' => 0],
                        ['title' => 'Programs', 'route' => 'program.index', 'active' => 1],
                    ]
                ])
            {{-- switching pages --}}
            @switch($currentPage)
            {{-- Index Page --}}
                @case('index')
                    <div class="col-md-12">
                        <div class="card p-0">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col-md-4 mt-4">
                                    <button type="button" class="btn btn-primary btn-sm" wire:click="create">
                                    <i class="fas fa-plus"></i>  Add Program
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" wire:click="printReport">
                                        <i class="fas fa-file-pdf"></i> Generate Program Schedule - PDF
                                        <i class="fas fa-sync-alt fa-spin" wire:loading wire:target="printReport"></i>
                                    </button>
                                </div>
                                <div class="col-md-8">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-md-3">
                                            <label>Program</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search" wire:model="searchText">
                                                <span class="input-group-append">
                                                  <button type="button" class="btn btn-default" wire:click="searchReport">
                                                      <i class="fas fa-search" wire:loading.hide wire:target="printReport"></i>
                                                      <i class="fas fa-sync-alt fa-spin" wire:loading wire:target="printReport"></i>
                                                  </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0 overflow-auto">
                                @if (isset($searchResult))
                                <table class="table table-striped table-inverse table-responsive table-bordered table-condensed table-hover">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>S/No</th>
                                            <th>Program</th>
                                            <th>Description</th>
                                            <th>Schedule</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($searchResult as $key => $program)
                                        <tr>
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
                                    </tbody>
                                </table>
                                @else
                                <table class="table table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr class="py-1">
                                            <th>ID</th>
                                            <th>Program</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($programs as $program)
                                        <tr>
                                            <td class="py-1">{{ $program->id }}</td>
                                            <td class="py-1">{{ $program->program }}</td>
                                            <td class="py-1">{{ $program->description }}</td>
                                            <td class="py-1">{{ $program->status }}</td>
                                            <td class="py-1">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm view-program" wire:click="view({{$program->id}})">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                                    <span class="sr-only">Action</span>
                                                    <div class="dropdown-menu" role="menu" style="">
                                                        <a class="dropdown-item edit-program" href="" wire:click.prevent="edit({{$program->id}})">
                                                            <i class="text-primary fas fa-pen"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="" wire:click.prevent="delete({{$program->id}})">
                                                            <i class="text-danger fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    @break
                {{-- create new program page --}}
                @case('new')
                    <div class="col-md-12">
                        <div class="card p-0">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-info btn-sm" wire:click="changePage('index')">
                                        <i class="fas fa-arrow-left"></i>  Back
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    @if (isset($edit))
                                        <h4 class="modal-title p-0">Editing - {{ $Program['name'] }}</h4>
                                    @else
                                        <h4 class="modal-title p-0">Add New Program</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body overflow-auto">
                                <form @if ($edit)
                                    wire:submit.prevent='update({{$edit}})'
                                    @else
                                    wire:submit.prevent='store'
                                @endif>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Program Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>

                                                        <input type="text" class="form-control @error('Program.name') is-invalid @enderror"
                                                        wire:model="Program.name" />
                                                        @error('Program.name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Program Description</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-table"></i>
                                                            </span>
                                                        </div>

                                                        <input type="text" class="form-control @error('Program.description') is-invalid @enderror"
                                                        wire:model="Program.description" />
                                                        @error('Program.description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr>
                                                    <label style="font-size: 20px;" for="active">Active</label>
                                                    <input type="checkbox" id="active" class="ml-2 @error('Program.status') is-invalid @enderror"
                                                    wire:model="Program.status" style=" width: 25px; height: 15px;" />
                                                    @error('Program.status')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="row d-flex justify-content-between px-2">
                                        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Close</button>
                                            @if ($edit)
                                                    <button type="submit" class="btn btn-dark btn-sm">
                                                Update Program
                                                @else
                                                    <button type="submit" class="btn btn-dark btn-sm">
                                                Add Program
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @break
                    {{-- View program page --}}
                    @case('view')
                        <div class="col-md-12">
                            <div class="card p-0">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-info btn-sm" wire:click="changePage('index')">
                                            <i class="fas fa-arrow-left"></i>  Back
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="modal-title p-0 text-center">{{$CurrentProgram->program}}</h4>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end">
                                        <button type="button" class="btn btn-dark btn-sm" wire:click="AddProgSchedule">Add Program Schedule</button>
                                    </div>
                                </div>
                                <div class="card-body overflow-auto">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="text-sm">Program
                                                <b class="d-block">{{ $CurrentProgram->program }}</b>
                                            </p>
                                            <p class="text-sm">Description
                                                <b class="d-block">{{ $CurrentProgram->description }}</b>
                                            </p>
                                            <p class="text-sm">Status
                                                <b class="d-block">{{ $CurrentProgram->status ? 'Active' : 'Inactive' }}</b>
                                            </p>
                                        </div>

                                        <div class="col-md-8">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($CurrentProgramSchedule as $schedule)
                                                    <tr>
                                                        <th>{{ $schedule->day->day }}</th>
                                                        <td>{{ $schedule->formatTimeFrom() }} - {{ $schedule->formatTimeTo() }}</td>
                                                        <td>{{ $schedule->duration }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-sm view-program" wire:click="editSchedule({{ $schedule->id }})">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm view-program" wire:click="deleteSchedule({{ $schedule->id }})">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @break
                @default

            @endswitch

        </div>
    </div>

    @livewire('program.program-schedule-com')

   @livewire('footer')
</div>

@push('scripts')
    <script>
        Livewire.on('AddNewProgramSchedule', function() {
            $('#programScheduleModal').modal('show');
        });

        Livewire.on('editProgSchedule', function() {
            $('#viewProgramModal').modal('hide');
            $('#programScheduleModal').modal('show');
        });
    </script>
@endpush
