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
    {{-- <div class="container" wire:poll.10000ms.keep-alive="LoadScheduledAdverts"> --}}
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
        <ul class="navbar-nav ml-auto">
          @if ($now)
          <li class="nav-item ml-auto pb-2 pt-3 mr-2">
            <button class="btn btn-sm {{ $notificationsOn ? 'btn-success' : 'btn-danger'}}" wire:click="toggleNotifications">
               <i class="fas fa-bell"></i> | {{ $notificationsOn ? 'Notifications ON' : 'Notifications OFF' }}
            </button>
          </li>
          <li class="nav-item ml-auto pb-2 pt-3">
            <button class="btn btn-sm {{ $autoPlay ? 'btn-success' : 'btn-danger'}}" wire:click="toggleAutoPlay">
               <i class="fas fa-play"></i> | {{ $autoPlay ? 'Auto-Play ON' : 'Auto-Play OFF' }}
            </button>
          </li>
          <li class="nav-item ml-auto pb-2 pt-3">
            <a href="#" class="nav-link text-primary h6" wire:poll.10000ms.keep-alive="LoadScheduledAdverts">
                {{$today}} | {{$now}}
            </a>
          </li>
          <li class="nav-item ml-auto pb-2 pt-3">
            @livewire('auth.logout')
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

    <div class="row">
        <div class="col-md-12 p-2 px-3">
            <div class="card">
                <div class="card-body border-0 shadow-none p-2" style="max-height: 80vh; overflow: auto;">
                    <div class="row d-flex">
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
                                <h5 class="time-{{$schedule->id}}">{{ date('h:i A', strtotime($schedule->play_time)) }}</h5>
                                <small>{{ $schedule->file->name }}</small>
                                <progress class="bar-{{$schedule->id}}" value="0" max="100" style="width:100%"></progress>
                                <audio src="{{asset('/adverts/uploads/' .$schedule->file->file)}}" id="player-{{$schedule->id}}"></audio>
                            </button>
                            @endif
                        @endforeach
                    </div>
                </div>
                {{-- <div class="card-footer text-muted border-0 shadow-none">
                    Footer
                </div> --}}
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            try {
                var notify;
                var logolink = "https://broadlog.dev/images/logo.png";
                var showNotification = function () {
                    if (!("Notification" in window)) {
                        alert("This browser does not support desktop notification");
                    }
                    notify = new Notification("Advert Notification", {
                        body: @this.notifyName + ' to be played on ' + @this.notifyTimeToPlay,
                        icon: logolink,
                    });

                    notify.onclick = function() {
                        @this.suspendNotification();
                    }
                }

                function createNotification() {
                    notify = new Notification('BroadLog', {
                        body: 'Loaded successfully',
                        icon: logolink,
                    });
                }

                if(Notification.permission != 'granted') {
                    Notification.requestPermission();
                    createNotification();
                } else {
                    createNotification();
                }

                $('.hold-transition').addClass('layout-top-nav');
                $('.hold-transition').removeClass('sidebar-mini');

                Livewire.on('PlayingNow', function(schedule) {
                    togglePlay(schedule.id)
                    @this.setAdvertPlayingVolume();
                });

                Livewire.on('PlayingNext', function(schedule) {
                    // console.log('playing next now...');
                    if(Notification.permission === 'granted') {
                        showNotification();
                    } else {
                        Notification.requestPermission().then(permission => {
                            if(permission === 'granted') {
                                showNotification();
                            }
                        });
                    }
                });
                // var schedules = @this.schedules;
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

                    if(play == false) {
                        stopTimer();
                    }

                    function stopTimer() {
                        @this.endNowPlaying();
                        clearInterval(timer);
                        pBtn.removeClass('fa-pause');
                        pBtn.addClass('fa-play');
                        $('.play-'+play).removeClass('btn-primary');
                        $('.play-'+play).addClass('btn-info');
                        $('.play-'+play).attr("disabled", true);
                        $('.bar-'+play).remove();
                    }
                }
                // var loadScheduledAdvertsAndCheckPlayTime = function() {
                //     @this.LoadScheduledAdverts();
                //     checkTime();
                // }

                // var checkTime = function() {
                //     setTimeout(() => {
                //         loadScheduledAdvertsAndCheckPlayTime();
                //     }, 10000);
                // }

                // checkTime();
                // try {
                //     setInterval(() => {
                //         @this.LoadScheduledAdverts();
                //     }, 10000);
                // } catch (updateError) {
                //     // console.log(updateError);
                // }
            } catch (error) {
                // console.log(error);
            }
        });
    </script>
@endpush
