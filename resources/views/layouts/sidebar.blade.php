<nav class="nav flex-column sidebar {{ $_COOKIE['openSideBar'] == 'true'? 'open':'' }}" id="sidebar-text">
    <a class="nav-link nav-user" href="{{ route('user.okr', auth()->user()->id) }}">
        <span>我的OKR</span>
    </a>
    <a class="nav-link nav-organization" href="{{ route('company.index') }}">
        <span>組織OKR</span>
    </a>
    <a class="nav-link nav-project" href="{{ route('project') }}">
        <span>我的專案</span>
    </a>
    <a class="nav-link nav-calendar" href="{{ route('calendar.index') }}">
        <span>工作日曆</span>
    </a>
    <a class="nav-link nav-follow" href="{{ route('follow.index') }}">
        <span>個人追蹤</span>
    </a>
</nav>
<nav class="nav flex-column sidebar" id="sidebar">
    <a class="nav-link text-center nav-user" href="{{ route('user.okr', auth()->user()->id) }}"><i class="fas fa-home" style="line-height: 24px"></i></a>
    <a class="nav-link text-center nav-organization" href="{{ route('company.index') }}"><i class="fas fa-sitemap" style="line-height: 24px"></i></a>
    <a class="nav-link text-center nav-project" href="{{ route('project') }}"><i class="fas fa-file-invoice" style="line-height: 24px"></i></a>
    <a class="nav-link text-center nav-calendar" href="{{ route('calendar.index') }}"><i class="fas fa-calendar-alt" style="line-height: 24px"></i></a>
    <a class="nav-link text-center nav-follow" href="{{ route('follow.index') }}"><i class="fas fa-star" style="line-height: 24px"></i></a>
</nav>
<div class="row u-pl-8 u-pr-8 bg-primary u-pt-8 sidebar-sm ml-0 mr-0">
    <a class="nav-link col text-center ml-auto mr-auto nav-user" href="{{ route('user.okr', auth()->user()->id) }}"><i class="fas fa-home" style="line-height: 24px; font-size: 24px;"></i><p class="mb-0 small">OKR</p></a>
    <a class="nav-link col text-center ml-auto mr-auto nav-organization" href="{{ route('company.index') }}"><i class="fas fa-sitemap" style="line-height: 24px; font-size: 24px;"></i><p class="mb-0 small">組織</p></a>
    <a class="nav-link col text-center ml-auto mr-auto nav-project" href="{{ route('project') }}"><i class="fas fa-file-invoice" style="line-height: 24px; font-size: 24px;"></i><p class="mb-0 small">專案</p></a>
    <a class="nav-link col text-center ml-auto mr-auto nav-calendar" href="{{ route('calendar.index') }}"><i class="fas fa-calendar-alt" style="line-height: 24px; font-size: 24px;"></i><p class="mb-0 small">日曆</p></a>
    <a class="nav-link col text-center ml-auto mr-auto nav-follow" href="{{ route('follow.index') }}"><i class="fas fa-star" style="line-height: 24px; font-size: 24px;"></i><p class="mb-0 small">追蹤</p></a>
</div>
