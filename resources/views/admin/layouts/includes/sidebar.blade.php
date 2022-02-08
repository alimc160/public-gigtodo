<aside id="left-panel" class="d-none-on-backend-precessing left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="index?dashboard">
                TRC4 <span class="badge badge-success p-2 font-weight-bold">ADMIN</span>
            </a>
            <a class="navbar-brand hidden" href="./"><span class="badge badge-success pt-2 pb-2">A</span></a>
        </div>
        <div id="main-menu" class="main-menu collapse navbar-collapse">

            <ul class="nav navbar-nav">

                <li class="pt-5">
                    <a href="{{route('admin.dashboard')}}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <li>
                    <a href="{{route('admin.dashboard')}}"> <i class="menu-icon fa fa-users"></i>Users </a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cubes"></i>Categories</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa  fa-arrow-circle-right"></i><a href="{{route('admin.categories.create')}}"> Insert Category</a></li>
                        <li><i class="fa  fa-arrow-circle-right"></i><a href="{{route('admin.categories.index')}}"> View Categories</a></li>
                    </ul>
                </li>
                <!----/>
                <li>
                  <a href="logout">
                    <i class="menu-icon fa fa-power-off"></i> Logout
                  </a>
                </li>
              <!-->
            </ul>
        </div>
    </nav>
</aside>
