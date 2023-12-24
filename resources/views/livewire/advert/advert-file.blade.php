<div class="modal fade" id="addFilesModal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-1 px-3">
                <h4 class="modal-title p-0">Add Files</h4>
            </div>
            <div class="modal-body p-0">
                <div class="card-body">
                   <div class="row">
                       <div class="col-md-6">
                       <form
                       @if ($editFile)
                        wire:submit.prevent='update({{ $editFile }})'
                        @else
                        wire:submit.prevent='store'
                        @endif id="file{{$filesNo}}">
                            <div class="row py-3">
                                <div class="col-md-12">
                                    <label>Advert/File name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-file"></i>
                                            </span>
                                        </div>
                                          <input type="text" class="form-control @error('name') is-invalid @enderror"
                                          wire:model="name" />

                                          @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Advert File</label>
                                          <input type="file" class="form-control overflow-hidden @error('audioFile') is-invalid @enderror"
                                            wire:model="audioFile" />
                                        @error('audioFile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="row d-flex justify-content-end px-2">
                                    @if ($editFile)
                                            <button type="submit" class="btn btn-dark btn-sm" id="updateFile">
                                        <i class="fas fa-edit"></i> Update File
                                        @else
                                            <button type="submit" class="btn btn-dark btn-sm" id="saveFile">
                                        <i class="fas fa-file-audio"></i> Add File
                                    @endif
                                </button>
                            </div>
                        </form>
                       </div>
                       <div class="col-md-6">
                            @if($files)
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
                                            <td class="py-1">{{$file->name}}</td>
                                            <td class="py-1">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm btn-sm playAddvertSample"
                                                 value="{{asset('/adverts/uploads/' .$file->file)}}">
                                                    <i class="fas fa-play"></i> Play
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                                  <span class="sr-only">Action</span>
                                                  <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item btn-sm" href="" wire:click.prevent="edit({{$file->id}})">
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
                            @endif
                       </div>
                       <div class="col-md-12">
                           <hr>
                       </div>
                   </div>
                   <div class="row d-flex justify-content-between px-2">
                    <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal" wire:click="filesAddFinished">Proceed to advert schedule</button>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
