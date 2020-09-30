@push('styles')
@endpush
<div class="wrapper">
    @livewire('navbar')
    @livewire('side-bar')
    <div class="content-wrapper">
    <div class="content-header">
        @livewire('partial.breadcrumb',
            [
                'page' => 'Advert Type',
                'links' => [
                    ['title' => 'Home', 'route' => 'admin.dashboard', 'active' => 0],
                    ['title' => 'Advert Types', 'route' => 'advert.type.index', 'active' => 1],
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
                                    Edit Advert Type
                                    @else
                                    Add Advert Type
                                @endif
                            </label>
                            <input type="text" class="form-control datetimepicker-input @error('type') is-invalid @enderror"
                            wire:model="type" />
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-dark btn-sm">
                                    @if ($edit)
                                        Update Advert Type
                                        @else
                                        Add Advert Type
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
                <h3 class="card-title">Advert Types</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered table-condensed table-hover">
                  <thead>
                    <tr class="py-1">
                      <th>ID</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($types as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td>{{ $type->type }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" wire:click="edit({{$type->id}})"
                                data-toggle="modal" data-target="#modal-edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" wire:click='delete({{$type->id}})'>
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
                {{ $types->links() }}
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
    @livewire('footer')
</div>

