<nav class="navbar navbar-expand navbar-light navbar-laravel tab-content">

    <!-- 左側選單按鈕 -->
    <div class="btn btn-menu text-primary">
        <i class="fas fa-bars"></i>
    </div>

    <!-- LOGO -->
    <a class="navbar-brand font-weight-bold text-primary ml-md-3" href="{{ route('user.okr', auth()->user()->id) }}">
        <img src="{{ asset('/img/logo/g.svg') }}" alt="">
        Goal Care
    </a>

    <!-- Right Side Of Navbar -->
    <div class="navbar-nav ml-auto">
        <form class="form-inline mr-md-5" action="{{route('search.index') }}">
            @csrf
            <input class="form-control mr-sm-1 search" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-search my-2 my-sm-0" type="submit"><i class="fas fa-search pt-1"></i></button>
            <a class="nav-item nav-link text-muted mt-auto mb-auto btn-search-sm" data-toggle="modal" data-target="#searchModal"><i
                    class="fas fa-search"></i></a>
        </form>

        <div class="btn-group">
            <div class="dropdown dropdown-notifications nav-item nav-link text-muted mt-auto mb-auto">
                <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                    <i data-count="0" class="fas fa-bell notification-icon"></i>
                </a>
                <div class="dropdown-container dropdown-menu">
                    <div class="dropdown-toolbar">
                        <div class="dropdown-toolbar-actions">
                            <a href="#">Mark all as read</a>
                        </div>
                        <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>
                    </div>
                    <ul class="dropdown-content">
                    </ul>
                    <div class="dropdown-footer text-center">
                        <a href="#">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <a data-toggle="dropdown" class="nav-item pl-2 pl-md-3 mt-auto mb-auto"><img src="{{ auth()->user()->getAvatar() }}"
                    class="avatar"></a>
            <a id="navbarDropdown" class="nav-item dropdown nav-link dropdown-toggle mt-auto mb-auto" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <span id="userName" class="nav-name" data-uid="{{ auth()->user()->id }}">{{ Auth::user()->name }}</span><span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('user.settings', auth()->user()->id) }}">帳號設定</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    登出
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">搜尋</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('search.index', auth()->user()->id) }}">
                <div class="modal-body">
                    @csrf
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">搜尋</button>
                </div>
            </form>
        </div>
    </div>
</div>
