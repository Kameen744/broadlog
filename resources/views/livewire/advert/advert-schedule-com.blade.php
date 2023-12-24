<div class="modal fade" id="addScheduleModal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;" wire:ignore.self>
        <div class="modal-content" wire:ignore.self>
            <div class="modal-header py-1 px-3">
                <h4 class="modal-title p-0">Advert Schedule</h4>
            </div>
            <div class="modal-body p-0">
                <div class="card-body" style="max-height: 85vh !important; overflow:auto;">
                   <div class="row">
                    <div class="col">
                        <form @if ($edit)
                            wire:submit.prevent='update({{$edit}})'
                            @else
                            wire:submit.prevent='store'
                        @endif>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <input type="text" disabled class="form-control @error('c_ad_time') is-invalid @enderror"
                                    wire:model="c_ad_date">
                                    @error('c_ad_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    @if ($files)
                                    <div class="form-group">
                                        <label>Select File</label>
                                            <select class="form-control @error('c_ad_file_id') is-invalid @enderror"
                                            wire:model="c_ad_file_id">
                                                <option value="">Select File</option>
                                                @foreach ($files as $file)
                                                    <option value="{{ $file->id }}">{{ $file->name }}</option>
                                                @endforeach
                                            </select>
                                        @error('c_ad_file_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <label>Time</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                            <input type="time" class="form-control @error('c_ad_time') is-invalid @enderror"
                                            wire:model="c_ad_time" />

                                            @error('c_ad_time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-between px-2 my-2">
                                    @if ($edit)
                                            <button type="submit" class="btn btn-dark btn-sm ml-auto" id="updateAdvert">
                                                <i class="fas fa-edit"></i> Update Time
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-dark btn-sm ml-auto" id="saveAdvert">
                                                <i class="fas fa-clock"></i> Set Time
                                            </button>
                                    @endif
                                <hr>
                            </div>
                        </form>
                        <div class="row">
                            @if ($c_schedules)
                            <div class="col-md-12" style="max-height: 400px; overflow-y: auto;">
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
                                                <td class="py-1">{{ $schedule->play_date }}</td>
                                                <td class="py-1">{{ date('h:i A', strtotime($schedule->play_time)) }}</td>
                                                <td class=" d-flex justify-content-end py-1">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn {{ $schedule->status ? 'btn-info' : 'btn-warning' }} btn-sm view-advert"
                                                        wire:click="updateActive({{$schedule->id}})">
                                                            {{ $schedule->status ? 'Active ' : 'Inactive ' }}<input type="checkbox" {{ $schedule->status ? 'checked' : '' }}>
                                                        </button>
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                                          <span class="sr-only">Action</span>
                                                          <div class="dropdown-menu" role="menu">
                                                            <a class="dropdown-item" href="" wire:click.prevent="edit({{$schedule->id}})">
                                                                <i class="text-info fas fa-pen"></i> Edit
                                                            </a>
                                                            <a class="dropdown-item" href="" wire:click.prevent="delete({{$schedule->id}})">
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
                        <div class="col">
                            <table class="table table-responsive">
                                <thead>
                                    @foreach ($callendar as $month)

                                    <tr>
                                        <td><b>{{ $month['month'] }}</b></td>
                                        @for ($i = 0; $i < count($month) -3; $i++)
                                            @php
                                                $adv_date = strtotime($month[$i]['date']);
                                            @endphp
                                            <th class="p-1">
                                                <b class="d-block text-center">{{ substr($month[$i]['date'], -2) }}</b>
                                                <i class="d-block text-center">{{ $month[$i]['day'] }}</i>

                                                <div class="d-block btn {{$form[$adv_date] ? 'btn-primary' : 'btn-danger'}} text-center"
                                                style="width: 28px; height: 28px; padding: 0px;" wire:click="selectDate({{$adv_date}})">
                                                    @isset ($form[$adv_date])
                                                        <b class="px-1">{{$form[$adv_date]}}</b>
                                                    @endisset
                                                </div>
                                            </th>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </thead>
                            </table>
                        </div>
                        <div class="col-1" style="max-height: 650px; overflow-y: auto;">
                            @if ($all_date_schedules)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Booked</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_date_schedules as $schedule)
                                            <tr>
                                                <td class="py-1">{{ date('h:i A', strtotime($schedule->play_time)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                       <div class="col-md-12">
                           <hr>
                       </div>
                   </div>
                   <div class="row d-flex justify-content-between px-2">
                    <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" wire:click="finishScheduling">Close</button>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
