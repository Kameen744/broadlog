<div class="wrapper">
    @livewire('navbar')
    @livewire('side-bar')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Index Page</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a>Home</a></li>
                    {{-- <li class="breadcrumb-item active">Starter Page</li> --}}
                  </ol>
                </div>
              </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-header">
                    Header
                </div>
                <div class="card-body">
                    <h4 class="card-title">Title</h4>
                    <p class="card-text">Text</p>
                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </div>
    @livewire('footer')
</div>
