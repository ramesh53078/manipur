<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{url('admin/assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Manipur</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('admin/assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->guard('admin')->user()->name}}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.employees')}}" class="nav-link {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Employees
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.visitors')}}" class="nav-link {{ request()->routeIs('admin.visitors') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Visitors
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.timewall.list')}}" class="nav-link {{ request()->routeIs('admin.timewall.list') ? 'active' : '' }}">
              <i class="nav-icon far fa-image"></i>
              <p>
                Time Wall
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.largevideowall.list')}}" class="nav-link {{ request()->routeIs('admin.largevideowall.list') ? 'active' : '' }}">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Large Video Wall
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>