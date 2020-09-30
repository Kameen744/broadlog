@push('styles')
@endpush
<div class="wrapper">
    @livewire('navbar')
    @livewire('side-bar')
    <div class="content-wrapper">
    <div class="content-header">
        @livewire('partial.breadcrumb',
            [
                'page' => 'Working Days',
                'links' => [
                    ['title' => 'Home', 'route' => 'admin.dashboard', 'active' => 0],
                    ['title' => 'Opening Days', 'route' => 'opening.days.index', 'active' => 1],
                ]
            ])
        <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form @if ($edit)
                        wire:submit.prevent='update({{$edit}})'
                        @else
                        wire:submit.prevent='store'
                    @endif>
                        <div class="form-group">
                            <label>
                                @if ($edit)
                                    Edit Day
                                    @else
                                    Add Day
                                @endif
                            </label>
                            <select class="form-control select2 select2-dark @error('form.day') is-invalid @enderror"
                            data-dropdown-css-class="select2-dark" style="width: 100%;" wire:model="form.day">
                              <option selected="selected" value="">Day</option>
                              <option value="Monday">Monday</option>
                              <option value="Tuesday">Tuesday</option>
                              <option value="Wednesday">Wednesday</option>
                              <option value="Thursday">Thursday</option>
                              <option value="Friday">Friday</option>
                              <option value="Saturday">Saturday</option>
                              <option value="Sunday">Sunday</option>
                            </select>
                            @error('form.day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Open From:</label>
                                      <input type="time" class="form-control datetimepicker-input @error('form.time_from') is-invalid @enderror"
                                        wire:model="form.time_from" />
                                    @error('form.time_from')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Close:</label>
                                      <input type="time" class="form-control datetimepicker-input @error('form.time_to') is-invalid @enderror"
                                      wire:model="form.time_to" />

                                      @error('form.time_to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark btn-sm">
                                    @if ($edit)
                                        Update Day
                                        @else
                                        Add Day
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-0">
              <div class="card-header">
                <h3 class="card-title">Opening Hours</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <thead>
                    <tr class="py-1">
                      <th>ID</th>
                      <th>Day</th>
                      <th>Time From</th>
                      <th>Time To</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($days as $day)
                    <tr>
                        <td>{{ $day->id }}</td>
                        <td>{{ $day->day }}</td>
                        <td>{{ $day->formatTimeFrom() }}</td>
                        <td>{{$day->formatTimeTo()}}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="edit({{$day->id}})"
                                data-toggle="modal" data-target="#modal-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" wire:click='delete({{$day->id}})'>
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{ $days->links() }}
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
    {{-- edit form modal --}}
    <div class="modal fade" id="modal-secondary">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h4 class="modal-title">Secondary Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-outline-light">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    @livewire('footer')
</div>
