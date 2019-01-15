<div class="container">
    <div class="row m-3">
        <div class="col-md-6">{{ $pages->links() }}</div>
        <div class="col-md-6 mb-2">
            <form action="{{ route('user.index',$user->id) }}" class="form-inline search-form">            
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4">
                        <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value="" placeholder="起始日">
                        <input type="text" class="form-control input-sm mr-2" name="search" placeholder="搜索">
                    </div>
                    <div class="col-md-4">
                        <input autocomplete="off" class="form-control input-sm" name="fin_date" id="filter_finished_at" value="" placeholder="完成日">
                        <select name="order" class="form-control input-sm mr-2">
                            <option value="">排序方式</option>
                            <option value="started_asc">起始日由近到遠</option>
                            <option value="started_desc">起始日由遠到近</option>
                            <option value="finished_desc">完成日由近到遠</option>
                            <option value="finished_asc">完成日由遠到近</option>
                            <option value="updated_desc">最近更新由近到遠</option>
                            <option value="updated_asc">最近更新由遠到近</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                    <button class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>
        </div>
        @if (auth()->user() == $user)
            <div class="col-md-3 font-weight-light"><h4>My OKR</h4> </div>
            <div class="col-md-2 offset-md-7 ">
                    <a href="#" class="btn btn-primary mr-2" data-toggle="modal" data-target="#objective"><i class="fa fa-plus fa-sm"></i> 新增目標 </a>
                {{-- <div class="btn-group">
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
                </div> --}}
            </div>
        @else
            <div class="col-md-2 text-right">
                <img class="avatar" src="{{ $user->avatar? asset($user->avatar):asset('/img/icon/user/green.svg') }}">    
            </div>
            <div class="col-md-10 font-weight-light align-self-end"><h4>{{ $user->name }}</h4> </div>          
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
    @include('okrs.okr', $okrs)
</div>






