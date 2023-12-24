
 {{-- add prog shedule modal --}}
 <div class="modal" data-keyboard="false" data-backdrop="static" id="programScheduleModal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header py-1 px-3">
                @if ($program)
                <h4 class="modal-title p-0">{{$program['program']}} - Schedule</h4>
                @endif
            </div>
            <div class="card-body">
                <form @if ($edit)
                    wire:submit.prevent='update({{$edit}})'
                    @else
                    wire:submit.prevent='store'
                @endif>
                <div class="row">
                    <div class="col-md-12">
                        <label>Day</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </div>

                            <select class="form-control @error('schedule.opening_day_id') is-invalid @enderror"
                            wire:model="schedule.opening_day_id">
                                <option value="">Select Day</option>
                                @foreach ($days as $day)
                                    <option value="{{$day->id}}">{{$day->day}}</option>
                                @endforeach
                            </select>
                            @error('schedule.opening_day_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label>Time From</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>

                            <input type="time" class="form-control @error('schedule.time_from') is-invalid @enderror"
                            wire:model="schedule.time_from" />
                            @error('schedule.time_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label>Time To</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>

                            <input type="time" class="form-control @error('schedule.time_to') is-invalid @enderror"
                            wire:model="schedule.time_to" />
                            @error('schedule.time_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <hr>
                    </div>

                    {{-- <div class="col-md-12 pb-2">
                        <label>Time Duration</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Minutes
                                </span>
                            </div>

                            <input type="number" class="form-control @error('schedule.duration') is-invalid @enderror"
                            wire:model="schedule.duration" />
                            @error('schedule.duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                </div>
                <hr>
                <div class="row d-flex justify-content-between px-2">
                    <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" wire:click="finishSchedule">Close</button>
                        @if ($edit)
                                <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-edit"></i> Update Schedule
                            @else
                                <button type="submit" class="btn btn-dark btn-sm">
                            <i class="fas fa-save"></i> Schedule
                        @endif
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
