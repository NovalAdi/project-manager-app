<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Messages -->
                @if (count(auth()->user()->to) > 0)
                    <span class="badge badge-danger badge-counter">{{ count(auth()->user()->to) }}</span>
                @endif
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                @foreach (auth()->user()->to as $notif)
                    <div class="dropdown-item">
                        <div class="font-weight-bold mb-2">
                            <div class="">{{ $notif->message }}</div>
                        </div>
                        <div class="d-flex">
                            <form action="{{ route('invitation.accept', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm mr-3">Accept</button>
                            </form>
                            <form action="{{ route('invitation.decline', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm mr-3">Decline</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->username }}</span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('uploads/users') . '/' . auth()->user()->image }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
