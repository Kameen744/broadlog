<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
         <h4 class="m-0 text-dark">{{$page}}</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          @foreach ($links as $link)
            @if (!$link['active'])
                <li class="breadcrumb-item">
                    <a href="{{route($link['route'])}}">{{ $link['title'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active">
                    {{ $link['title'] }}
                </li>
            @endif
          @endforeach
        </ol>
      </div>
    </div>
    <hr>
</div>
