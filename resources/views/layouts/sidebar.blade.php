
<nav class="nav flex-column sidebar" id="sidebar-text">
    <a class="nav-link" href="{{ route('okrs.index', auth()->user()->id) }}">
        <span>我的OKR</span>
    </a>
    <a class="nav-link" href="">
        <span>組織OKR</span>
    </a>
    <a class="nav-link" href="">
        <span>我的專案</span>
    </a>
    <a class="nav-link" href="">
        <span>工作日曆</span>
    </a>
    <a class="nav-link" href="">
        <span>個人追蹤</span>
    </a>
</nav>
<nav class="nav flex-column sidebar" id="sidebar">
    <a class="nav-link" href="{{ route('okrs.index', auth()->user()->id) }}"><img src="{{ asset('/img/icon/home/w.svg') }}" alt=""></a>
    <a class="nav-link" href=""><img src="{{ asset('/img/icon/okr/w.svg') }}" alt=""></a>
    <a class="nav-link" href=""><img src="{{ asset('/img/icon/project/w.svg') }}" alt=""></a>
    <a class="nav-link" href=""><img src="{{ asset('/img/icon/calendar/w.svg') }}" alt=""></a>
    <a class="nav-link" href=""><img src="{{ asset('/img/icon/like/w.svg') }}" alt=""></a>
</nav>