<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <a class="link-fx font-w600 font-size-lg text-white" href="{{route('quizable.quiz.index')}}">
                <span class="smini-visible">
                    <span class="text-white-75">{{config('quizable.appname')}}</span>
                </span>
                <span class="smini-hidden">
                    <span class="text-white-75">{{config('quizable.appname')}} </span>
                </span>
            </a>
            <div>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li class="nav-main-item mb-4">
                <a class="nav-main-link  @if(request()->routeIs('quizable.dashboard')) active @endif " href="{{route('quizable.dashboard')}}">
                    <i class="nav-main-link-icon si si-cursor"></i>
                    <span class="nav-main-link-name">Welcome</span>
                </a>
            </li>
            <li class="nav-main-item open">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon si si-grid"></i>
                    <span class="nav-main-link-name">Quizables</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link @if(request()->routeIs('quizable.quiz.*')) active @endif "  href="{{route('quizable.quiz.index')}}">
                            <span class="nav-main-link-name">Quizes</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</nav>
