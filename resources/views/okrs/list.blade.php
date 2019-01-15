<div class="container">
    <div class="row m-3">
        @if ( auth()->user() == $owner)
        <div class="col-md-7 font-weight-light">
            <h4>我的OKR</h4>
        </div>
        @else
        <a class="col-md-7" href="{{ $owner->getOKrRoute() }}">
            <img class="avatar u-ml-8 u-mr-8" src="{{ $owner->getAvatar() }}">
            <h4 class="list-inline-item u-ml-8 u-mr-8 text-black-50">{{ $owner->name }}</h4>
        </a>
        @endif
        @if (auth()->user()->id == $admin)
        <div class="col-md-5 text-right align-self-end">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#objective"><i class="fa fa-plus fa-sm"></i>
                新增目標</a>
        </div>
        @endif
        <div class="col-md-6">{{ $pages->links() }}</div>
        <div class="col-md-6 mb-2">
            <form action="{{ route('user.index',$owner->id) }}" class="form-inline search-form">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4">
                        <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at"
                            value="" placeholder="起始日">
                        <input type="text" class="form-control input-sm mr-2" name="search" placeholder="搜索">
                    </div>
                    <div class="col-md-4">
                        <input autocomplete="off" class="form-control input-sm" name="fin_date" id="filter_finished_at"
                            value="" placeholder="完成日">
                        <select name="order" class="form-control input-sm mr-2">
                            <option value="">排序方式</option>
                            <option value="started_at_asc">起始日由近到遠</option>
                            <option value="started_at_desc">起始日由遠到近</option>
                            <option value="finished_at_desc">完成日由近到遠</option>
                            <option value="finished_at_asc">完成日由遠到近</option>
                            <option value="updated_at_desc">最近更新由近到遠</option>
                            <option value="updated_at_asc">最近更新由遠到近</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>
        </div>
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
