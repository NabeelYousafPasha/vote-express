<!-- ======== Start Navbar ======== -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="padding: 0%;background-color: white !important">
    <div class="container">
        <a class="navbar-brand" style="padding: 0%" style="margin" href="{{ route('home') }}"><img src="{{ asset('img/vote.png') }}" style="width: 20%; padding-bottom:0px; padding-top:0px " alt="logo"></a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="@if(Route::currentRouteName() != 'home'){{ route('home') }}@else #slider @endif">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('explore') }}">Explore</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#benefits">Benefits</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="@if(Route::currentRouteName() != 'home'){{ route('home') }}@else #price @endif">Price</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="@if(Route::currentRouteName() != 'home'){{ route('home') }}@else #contact @endif">Contact</a>
                </li>

            </ul>
            @guest
            <!---- Modal login and register -->
            <a href="#myModal" role="button" class="btn-1" data-toggle="modal">Login</a>
            <!-- SImple login route -->
            {{-- <a href="/login" role="button" class="btn-1">Login</a> --}}
            @else
            <div>
                <span class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <span class="avatar rounded-circle">
                            <img alt="Image placeholder" class="rounded-circle" width="50" src="{{ asset('storage/'.auth()->user()->profile_image ?? 'storage/uploads/User_icon_BLACK-01.png') }}">
                        </span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- Impersonating -->
                        @impersonating
                        <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('impersonate-form').submit();">
                            Stop Impersonating
                        </a>
                        <form id="impersonate-form" action="{{ route('admin.users.impersonate.destroy') }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endimpersonating
                        <a class="dropdown-item {{ return_if(on_page('account.dashboard'), ' active') }}"
                            href="{{ route('account.dashboard') }}">
                            My Dashboard
                        </a>
                        <!-- Admin Panel Link -->
                        @role('admin-root')
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            Admin Panel
                        </a>
                        @endrole
                        @role('developer')
                        <!-- Developer Link -->
                        <a class="dropdown-item" href="{{ route('developer.index') }}">
                            Developer Panel
                        </a>
                        @endrole
                        <!-- User Account Link -->
                        <a class="dropdown-item" href="{{ route('account.index') }}">
                            My Account
                        </a>
                        
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        @include('layouts.partials.forms._logout')
                    </div>
                </span>
            </div>
            @endguest
        </div>
    </div>
</nav>
<!-- ======== End Navbar ======== -->