<div class="col-md-3">
    <div class="card u-mt-16 u-margin-4" draggable="true" >
        <div class="card-header">
            <div class="row">
                <div class="col-12 text-right">
                    @if ($department->follower->first())
                    <a href="{{ route('follow.cancel', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="取消追蹤">
                        <i class="fas fa-star" style="font-size: 24px;"></i>
                    </a>
                    @else
                    <a href="{{ route('follow', [get_class($department), $department]) }}" class="text-warning" data-toggle="tooltip" data-placement="right" title="追蹤">
                        <i class="far fa-star" style="font-size: 24px;"></i>
                    </a>
                    @endif
                </div>
            </div>
            <div class="row">
                    <div class="col-12">
                        <a href="{{ route('department.okr', $department->id) }}">
                            <img src="{{ $department->getAvatar() }}" alt="" class="avatar-md u-ml-8 u-mr-8">
                            <div class="d-inline-block">
                                <span class="mb-0 font-weight-bold text-black-50">{{ $department->name }}</span><br>
                                <span class="mb-0 font-weight-bold text-black-50">{{ $department->description }}</span>
                            </div>
                        </a>
                        {{-- <div class="u-ml-8 u-mr-8 d-inline-block">
                            <a href="{{ route('department.okr', $department->id) }}">
                            </a>
                            @if ($department->children->count()>0 && $show)
                            <a href="{{ route('department.index', $department) }}"><i class="far fa-plus-square pl-2"></i></a>
                            @endif
                            <br>
                        </div> --}}
                    </div>
                </div>
            </div>
        
        
        @if ($department->okrs)
        @foreach ($department->okrs as $okrs)
        <div class="row justify-content-center mb-4">
            <div class="col-lg-3 text-center">
                <span class="font-weight-bold text-black-50" style="font-size:14px;">Objective</span>
            </div>
            <div class="col-lg-7 text-black-50 text-center text-lg-left">{{ $okrs['objective']->title }}</div>
        </div>
        @endforeach
        @endif
        <div class="row">
            <div class="col-12 text-right pr-4 pb-2">
                @if ($department->user_id == auth()->user()->id)
                <a href="{{ route('department.create', $department->id) }}" data-toggle="tooltip" data-placement="bottom"
                    title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
                <a href="{{ route('department.member.setting', $department->id) }}" data-toggle="tooltip" data-placement="bottom"
                    title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
                <a href="{{ route('department.edit', $department->id) }}" data-toggle="tooltip" data-placement="bottom"
                    title="編輯部門"><i class="fas fa-edit u-margin-4"></i></a>
                <a href="#" onclick="document.getElementById('departmentDelete{{ $department->id }}').submit()" data-toggle="tooltip"
                    data-placement="bottom" title="刪除部門"><i class="fas fa-trash-alt"></i></a>
                <form method="POST" id="departmentDelete{{ $department->id }}" action="{{ route('department.destroy', $department->id) }}">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
