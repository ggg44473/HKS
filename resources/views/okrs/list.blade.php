<div class="container">
    <div class="row m-3">
        @if ( auth()->user() == $owner)
            <div class="col-md-7 font-weight-light"><h4>我的OKR</h4> </div>
        @else
            <a class="col-md-7" href="{{ $owner->getOKrRoute() }}">
                <img class="avatar u-ml-8 u-mr-8" src="{{ $owner->getAvatar() }}">
                <h4 class="list-inline-item u-ml-8 u-mr-8 text-black-50">{{ $owner->name }}</h4>
            </a>       
        @endif  
        @if (auth()->user()->id == $admin)
            <div class="col-md-5 text-right align-self-end">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#objective"><i class="fa fa-plus fa-sm"></i> 新增目標</a>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-history fa-sm"></i> 歷史紀錄
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">2018  Q1</a>
                        <a class="dropdown-item" href="#">2018  Q2</a>
                        <a class="dropdown-item" href="#">2018  Q3</a>
                        <a class="dropdown-item" href="#">2018  Q4</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">2017</a>
                    </div>                        
                </div>
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                @include('okrs.create', ['route'=>$route]) 
            </div>
        </div>
    </div>
    @include('okrs.okr', ['admin'=>$admin, $okrs])
</div>






