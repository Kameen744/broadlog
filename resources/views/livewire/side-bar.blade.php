<div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-dark-navy">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
          <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
               style="opacity: .8">
        <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('images/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">{{$username}}</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($links as $key => $link)
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-th"></i>
                      <p>
                        {{ $link['title'] }}
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @livewire('navlinks.sub-link', ['sublinks' => $link['props']]) --}}
                        @foreach ($link['props'] as $sublink)
                            <li class="nav-item">
                                <a href="{{ route($sublink['route']) }}" class="nav-link">
                                    <i class="fas fa-link nav-icon"></i>
                                    <p>{{$sublink['name']}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                  </li>
                @endforeach
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
</div>
