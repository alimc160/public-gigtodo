<header id="header" class="header">
    <div class="header-menu"><div class="col-sm-7">

        </div>

        <div class="col-sm-5">

            <div class="user-area dropdown float-right">

                <button class="btn btn-outline-secondary btn-sm dropdown-toggle text=white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img src="http://localhost/gigtodo/GigToDo_Freelance_Marketplace_153_TRC4_EDIT///admin/admin_images/black.png" width="30" height="30" class="rounded-circle text-white">

                    &nbsp; admin  &nbsp; <span class="caret"></span>

                </button>

                <div class="user-menu dropdown-menu">

                    <a class="nav-link" href="index?dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>

                    <a class="nav-link"  href="index?user_profile=1">
                        <i class="fa fa-user"></i> My Profile
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>

                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</header>
