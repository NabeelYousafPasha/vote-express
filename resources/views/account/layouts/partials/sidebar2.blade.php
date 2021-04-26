<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/vote.png') }}" class="navbar-brand-img" style="max-height: 4.5rem;" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
                    data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.dashboard'), ' active') }}"
                            href="#">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="nav-link-text">Dashboards</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.brand.index'), ' active') }}" href="#" >
                            <i class="fas fa-calendar"></i>
                            <span class="nav-link-text">Brand Management</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.contest.index'), ' active') }}" href="#navbar-contests" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-contests">
                            <i class="fas fa-cubes"></i>
                            <span class="nav-link-text">Contest Management</span>
                        </a>
                        <div class="collapse" id="navbar-contests">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        All Contests
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        Add a Contest
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.contestants.index'), ' active') }}" href="#navbar-contestants" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-contestants">
                            <i class="fas fa-users"></i>
                            <span class="nav-link-text">Contestants</span>
                        </a>
                        <div class="collapse" id="navbar-contestants">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        All Contestants
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.index') or on_page('account.profile.index') or on_page('account.password.index') or on_page('account.deactivate.index') or on_page('account.twofactor.index') , ' active') }}" href="#navbar-examples" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-examples">
                            <i class="fas fa-user"></i>
                            <span class="nav-link-text">Account</span>
                        </a>
                        <div class="collapse" id="navbar-examples">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="#">
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.password.index'), ' active') }}"
                                        href="#">
                                        Change password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.deactivate.index'), ' active') }}"
                                        href="#">
                                        Deactivate account
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('account.subscription.swap.index') or on_page('account.subscription.cancel.index') or on_page('account.subscription.invoice.index') or on_page('account.subscription.card.index') or on_page('account.subscription.team.index'), ' active') }}" href="#navbar-components" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-components">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                            <span class="nav-link-text">Subscription</span>
                        </a>
                        <div class="collapse" id="navbar-components">
                            <ul class="nav nav-sm flex-column">
                                {{-- @subscriptionnotcancelled --}}
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.subscription.swap.index'), ' active') }}"
                                        href="#">
                                        Change plan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.subscription.cancel.index'), ' active') }}"
                                        href="#">
                                        Cancel subscription
                                    </a>
                                </li>

                                @subscriptioncancelled
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.subscription.resume.index'), ' active') }}"
                                        href="#">
                                        Resume subscription
                                    </a>
                                </li>
                                @endsubscriptioncancelled
                                @teamsubscription
                                <li class="nav-item">
                                    <a class="nav-link{{ return_if(on_page('account.subscription.team.index'), ' active') }}"
                                        href="#">
                                        Manage team
                                    </a>
                                </li>
                                @endteamsubscription
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ return_if(on_page('plans.index') or on_page('plans.teams.index'), ' active') }}" href="#navbar-plans" data-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="navbar-forms">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="nav-link-text">Pricing Plan</span>
                        </a>
                        <div class="collapse" id="navbar-plans">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link{{ return_if(on_page('plans.index'), ' active') }}"
                                            href="#">
                                            <i class="far fa-user"></i>
                                            Membership Plan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    </li>
                    {{-- @endnotsubscribed --}}

                   

                    
                    
                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('account.reports.index'), ' active') }}" href="#">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-link-text">Report</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link{{ return_if(on_page('account.mynotification.index'), ' active') }}" href="#navbar-notifications" data-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="navbar-notifications">
                            <i class="fas fa-bell"></i>
                            <span class="nav-link-text">Notification</span>
                        </a>
                        <div class="collapse" id="navbar-notifications">
                            <ul class="nav nav-sm flex-column">
                                <a class="nav-link{{ return_if(on_page('account.mynotification.index'), ' active') }}"
                                    href="#">
                                    Notification
                                </a>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted text-center">Vote-Express V1.0</h6>
                <hr style="margin-top: 2px;
                background-color: #5e72e4;
                min-width: 50% !important;">
            </div>
        </div>
    </div>
</nav>