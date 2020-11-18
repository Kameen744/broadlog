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
                    ['title' => 'Adverts', 'route' => 'advert.index', 'active' => 1],
                ]
            ])
        <div class="col-md-12">
            <div class="card p-0">
              <div class="card-header d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-primary btn-sm" id="NewAdvert" data-target="#modal-edit">Add New Advert</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 overflow-auto">
                <table class="table table-bordered table-condensed table-hover">
                  <thead>
                    <tr class="py-1">
                      <th>ID</th>
                      <th>Client</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Duration</th>
                      <th>Rate</th>
                      <th>Slots</th>
                      <th>Discount</th>
                      <th>Commission</th>
                      <th>Start</th>
                      <th>Finish</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($adverts as $advert)
                    <tr>
                        <td class="py-1">{{ $advert->id }}</td>
                        <td class="py-1">{{ $advert->client }}</td>
                        <td class="py-1">{{ $advert->phone_no }}</td>
                        <td class="py-1">{{ $advert->email }}</td>
                        <td class="py-1">{{ $advert->duration }}</td>
                        <td class="py-1">{{ $advert->rate }}</td>
                        <td class="py-1">{{ $advert->slots }}</td>
                        <td class="py-1">{{ $advert->discount }}</td>
                        <td class="py-1">{{ $advert->commision }}</td>
                        <td class="py-1">{{ $advert->start_date }}</td>
                        <td class="py-1">{{ $advert->finish_date }}</td>
                        <td class="py-1">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm view-advert" wire:click="view({{$advert->id}})">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                  <span class="sr-only">Action</span>
                                  <div class="dropdown-menu" role="menu" style="">
                                    <a class="dropdown-item edit-advert" href="" wire:click.prevent="edit({{$advert->id}})">
                                        <i class="text-primary fas fa-pen"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="" wire:click.prevent="delete({{$advert->id}})">
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
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $adverts->links() }}
              </div>
            </div>
          </div>
        </div>
    </div>
    {{-- New modal --}}
    <div class="modal hide fade in" data-keyboard="false" data-backdrop="static" id="newAdvertModal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header py-1 px-3">
              <h4 class="modal-title p-0">
                @if ($edit)
                    Edit Advert
                @else
                    Add new advert
                @endif
              </h4>
            </div>
            <div class="modal-body p-0">
                <div class="card-body">
                    <form @if ($edit)
                        wire:submit.prevent='update({{$edit}})'
                        @else
                        wire:submit.prevent='store'
                    @endif>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Client name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>

                                    <input type="text" class="form-control @error('form.client') is-invalid @enderror"
                                    wire:model="form.client" />
                                    @error('form.client')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </div>

                                        <input type="number" class="form-control @error('form.phone_no') is-invalid @enderror"
                                        wire:model="form.phone_no" />

                                    @error('form.phone_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6 py-3">
                                <label>Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </div>
                                        <input type="email" class="form-control @error('form.email') is-invalid @enderror"
                                        wire:model="form.email" />

                                        @error('form.email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 py-3">
                                <label>Source / Agency</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </span>
                                    </div>
                                        <input type="text" class="form-control @error('form.source') is-invalid @enderror"
                                        wire:model="form.source" />

                                        @error('form.source')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Duration</label>
                                <div class="input-group">
                                    <div class="input-group-prepend c-pointer" wire:click="changeDuration">
                                        <span class="input-group-text bg-info border-info">
                                            {{ $seconds }}
                                        </span>
                                    </div>
                                        <input type="number" class="form-control @error('form.duration') is-invalid @enderror"
                                        wire:model="form.duration" />
                                    @error('form.duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Rate</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            ₦
                                        </span>
                                    </div>
                                        <input type="number" class="form-control @error('form.rate') is-invalid @enderror"
                                        wire:model="form.rate" />

                                        @error('form.rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <label>Slots</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            00
                                        </span>
                                    </div>
                                        <input type="number" class="form-control @error('form.slots') is-invalid @enderror"
                                        wire:model="form.slots" />
                                    @error('form.slots')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Discount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend c-pointer" wire:click="changePercent('discount')">
                                        <span class="input-group-text bg-info border-info">
                                            {{ $discount }}
                                        </span>
                                    </div>
                                        <input type="number" class="form-control @error('form.discount') is-invalid @enderror"
                                        wire:model="form.discount" />

                                        @error('form.discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Commision</label>
                                <div class="input-group">
                                    <div class="input-group-prepend c-pointer" wire:click="changePercent('commision')">
                                        <span class="input-group-text bg-info border-info">
                                            {{ $commission }}
                                        </span>
                                    </div>
                                        <input type="number" class="form-control @error('form.commision') is-invalid @enderror"
                                        wire:model="form.commision" />
                                    @error('form.commision')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Advert Type</label>
                                        <select class="form-control @error('form.advert_type_id') is-invalid @enderror"
                                        wire:model="form.advert_type_id">
                                            <option value=""></option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.advert_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                        <input type="date" class="form-control @error('form.start_date') is-invalid @enderror"
                                        wire:model="form.start_date" />
                                    @error('form.start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Finish Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control @error('form.finish_date') is-invalid @enderror"
                                    wire:model="form.finish_date" />
                                        @error('form.finish_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row d-flex justify-content-between px-2">
                            <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" wire:click="endEdit">Close</button>

                                @if ($edit)
                                        <button type="submit" class="btn btn-dark btn-sm" id="updateAdvert">
                                    Update Advert
                                    @else
                                        <button type="submit" class="btn btn-dark btn-sm" id="saveAdvert">
                                    Add New Advert
                                @endif
                            </button>
                        </div>
                    </form>
                </div>

            </div>
          </div>
        </div>
      </div>
    {{-- view Modal --}}
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="viewAdvertModal" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-1">
                    <div class="card" style="max-height: 85vh !important; overflow:auto;">
                        <div class="card-header">
                          <h3 class="card-title">Advert Details</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                              <i class="fas fa-times"></i></button>
                          </div>
                        </div>
                        <div class="card-body">
                        @if($viewingAdvert)
                          <div class="row">
                            <div class="col-12 col-md-12 order-2 order-md-1">
                              <div class="row">
                                <div class="col-12 col-sm-2">
                                    <div class="info-box bg-light">
                                      <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Duration</span>
                                      <span class="info-box-number text-center text-muted mb-0">

                                          @if ($viewingAdvert->duration >= 60)
                                            {{ $viewingAdvert->duration / 60 }} Min
                                          @else
                                            {{ $viewingAdvert->duration }} Secs
                                          @endif

                                        <span>
                                      </span></span></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-2">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <span class="info-box-text text-center text-muted">Slots</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $viewingAdvert->slots }}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <span class="info-box-text text-center text-muted">Rate</span>
                                    <span class="info-box-number text-center text-muted mb-0">₦ {{ $viewingAdvert->rate }}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="info-box bg-light">
                                      <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Amount</span>
                                      <span class="info-box-number text-center text-muted mb-0">₦ {{ $viewingAdvert->rate * $advert->slots }}<span>
                                      </span></span></div>
                                    </div>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <h4>{{ $viewingAdvert->client }}</h4>
                                  <div class="">
                                    <p class="text-sm">Type
                                        <b class="d-block">{{$viewingAdvert->type->type}}</b>
                                      </p>
                                    <p class="text-sm">Client Email
                                      <b class="d-block">{{ $viewingAdvert->email }}</b>
                                    </p>
                                    <p class="text-sm">Registered on
                                      <b class="d-block">{{ $viewingAdvert->created_at }}</b>
                                    </p>
                                    <p class="text-sm">Start Date
                                        <b class="d-block">{{ $viewingAdvert->start_date }}</b>
                                    </p>
                                    <p class="text-sm">Finish
                                        <b class="d-block">{{ $viewingAdvert->finish_date }}</b>
                                    </p>
                                  </div>
                                </div>
                                @if ($files)

                                <div class="col-md-4">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($files as $file)
                                                <tr>
                                                    <td>{{$file->name}}</td>
                                                    <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm btn-sm playAddvertSample"
                                                         value="{{asset('/adverts/uploads/' .$file->file)}}">
                                                            <i class="fas fa-play"></i> Play
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                                          <span class="sr-only">Action</span>
                                                          <div class="dropdown-menu" role="menu">
                                                            <a class="dropdown-item btn-sm" href="" wire:click.prevent="editFile({{$file->id}})">
                                                                <i class="text-info fas fa-pen"></i> Edit
                                                            </a>
                                                            <a class="dropdown-item btn-sm" href="" wire:click.prevent="deleteFile({{$file->id}})">
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
                                </div>
                                @endif


                                    @if ($c_schedules)
                                    <div class="col-md-5">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($c_schedules as $schedule)
                                                    <tr>
                                                        <td>{{ $schedule->play_date }}</td>
                                                        <td>{{ date('h:i A', strtotime($schedule->play_time)) }}</td>
                                                        <td class=" d-flex justify-content-end">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-info btn-sm view-advert" wire:click="editSchedule({{$schedule->id}})">
                                                                    <i class="fas fa-pen"></i> Edit
                                                                </button>
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                                                  <span class="sr-only">Action</span>
                                                                  <div class="dropdown-menu" role="menu" style="">
                                                                    <a class="dropdown-item" href="" wire:click.prevent="deleteSchedule({{$schedule->id}})">
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
                                    </div>
                                    @endif


                              </div>
                            </div>

                          </div>
                          @endif
                        </div>
                        <!-- /.card-body -->

                      </div>
                      <hr class="m-0 p-0">

                      @if ($viewingAdvert)
                      <div class="row d-flex justify-content-end px-4 py-2">
                        <button type="button" class="btn btn-dark btn-sm mr-auto" data-dismiss="modal" wire:click="endViewing">Close</button>
                        <button class="btn btn-sm btn-primary mx-2" wire:click="addFile({{$viewingAdvert->id}})">
                            <i class="fas fa-file-upload"></i> Upload Advert Files
                        </button>
                        {{-- <button class="btn btn-sm btn-info mx-2" id="editFiles"><i class="fas fa-pen"></i> Edit files</button> --}}
                        <button class="btn btn-sm btn-info mx-2" wire:click="addSchedule({{$viewingAdvert->id}})">
                            <i class="fas fa-clock"></i> Advert schedule
                        </button>
                        {{-- <button class="btn btn-sm btn-info ml-2" id="editSlots"><i class="fas fa-pen"></i> Edit schedule</button> --}}
                    </div>
                      @endif
                </div>
            </div>
        </div>
    </div>

    @livewire('advert.advert-file')
    @livewire('advert.advert-schedule-com')

    <div class="modal" data-keyboard="false" data-backdrop="static" id="editModal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-1 px-3">
                <h4 class="modal-title p-0">New Advert</h4>
                </div>
                <div class="modal-body p-0">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('footer')
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            var advAudio = null;
            $('#NewAdvert').click(function() {
                $('#newAdvertModal').modal('show');
            });

            $('.edit-advert').click(function() {
                $('#newAdvertModal').modal('show');
            });

            $('.view-advert').click(function() {
                $('#viewAdvertModal').modal('show');
                advAudio = new Audio();
            });

            $(document).on('click', '.playAddvertSample', function() {
                if(advAudio.paused) {
                    advAudio.src = $(this).val();
                    advAudio.play();
                    $(this).html('<i class="fas fa-pause"></i>');
                } else {
                    advAudio.pause();
                    $(this).html('<i class="fas fa-play"></i> Play');
                }
            });

            Livewire.on('addScheduleEvent', function() {
                $('#addScheduleModal').modal('show');
            });

            Livewire.on('editSchedule', function() {
                $('#addScheduleModal').modal('show');
            });

            Livewire.on('addFileEvent', function() {
                $('#addFilesModal').modal('show');
                bsCustomFileInput.init();
                advAudio = new Audio();
            });

            Livewire.on('advertSaved', function() {
                $('#newAdvertModal').modal('hide');
            });

            Livewire.on('advertUpdated', function() {
                $('#newAdvertModal').modal('hide');
            });

            Livewire.on('endViewingAdvert', function() {
                try {
                    if(advAudio) {
                        advAudio.pause();
                    }
                } catch (error) {
                    console.log(error);
                }
            });
            Livewire.on('editFile', function() {
                $('#addFilesModal').modal('show');
                bsCustomFileInput.init();
            });
        });
    </script>
@endpush
