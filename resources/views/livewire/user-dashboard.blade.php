@push('styles')
    <style>
        progress[value] {
            width: 100%;
            height: 5px;
        }
    </style>
@endpush
<div class="wrapper">
   <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="{{ route('user.dashboard') }}" class="navbar-brand">
        <img src="{{ asset('images/logo.png') }}" style="width:60px; height:60px;" alt="BroadMedia" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>

              <li class="dropdown-divider"></li>

              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>

                  <!-- Level three dropdown-->
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>
                  <!-- End Level three -->

                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </nav>

    <div class="row">
        <div class="col-md-12 p-2 px-3">
            <div class="card">
                <div class="card-body p-2" style="max-height: 80vh; overflow: auto;">
                    <div class="row d-flex justify-content-center">
                        @foreach ($schedules as $key => $schedule)
                            @if ($schedule->played)
                                <button class="btn btn-info m-2" disabled>
                                    <i class="fas fa-play"></i>
                                    <h6 class="time-{{$schedule->id}}">{{ date('h:i A', strtotime($schedule->play_time)) }}</h6>
                                    {{-- <progress class="bar-{{$schedule->id}}" value="100" max="100" style="width:100%"></progress> --}}
                                </button>
                            @else
                            <button class="btn btn-danger m-2 play-{{$schedule->id}}"
                                value="{{asset('/adverts/uploads/' .$schedule->file->file)}}"
                                wire:click="play({{$schedule->id}})" wire:ignore>

                                <i class="fas play-icon-{{$schedule->id}} fa-play"></i>
                                <h6 class="time-{{$schedule->id}}">{{ date('h:i A', strtotime($schedule->play_time)) }}</h6>

                                <progress class="bar-{{$schedule->id}}" value="0" max="100" style="width:100%"></progress>
                                <audio src="{{asset('/adverts/uploads/' .$schedule->file->file)}}" id="player-{{$schedule->id}}"></audio>
                            </button>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.hold-transition').addClass('layout-top-nav');
            $('.hold-transition').removeClass('sidebar-mini');

            Livewire.on('PlayingNow', function(sch) {
                togglePlay(sch.id)
            });

            var togglePlay = function(elmId)
            {
                let pBtn = $('.play-icon-' + elmId);
                let pBar = $('.bar-'  + elmId);
                let player = document.getElementById('player-' + elmId);

                if(player.paused) {
                    player.play();
                    pBtn.removeClass('fa-play');
                    pBtn.addClass('fa-pause');
                    advance(player.duration, pBtn, pBar, player, elmId);
                } else {
                    player.pause();
                    advance(player.duration, pBtn, pBar, player, false);
                }
            }


            var advance = function(duration, pBtn, pBar, player, play) {
                pBar.attr('max', duration);
                $('#tTime-'+play).html(Math.ceil(duration));
                $('.play-'+play).removeClass('btn-danger');
                $('.play-'+play).addClass('btn-primary');
                var percent = 0;

                var timer = setInterval(() => {
                    if(percent < duration) {
                        percent = player.currentTime;
                        $('#duration-'+play).html(Math.ceil(percent));
                        pBar.val(percent);
                    } else {
                        stopTimer();
                    }
                }, 1000);

                if(!play) {
                    stopTimer();
                }

                function stopTimer() {
                    clearInterval(timer);
                    pBtn.removeClass('fa-pause');
                    pBtn.addClass('fa-play');
                    $('.play-'+play).removeClass('btn-primary');
                    $('.play-'+play).addClass('btn-info');
                    $('.play-'+play).attr("disabled", true);
                    $('.bar-'+play).remove();
                }
            }
        });
    </script>
@endpush
