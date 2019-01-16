<div class="u-margin-4 u-ml-16">
        <div class="row">
            <a href="{{ route('department.okr', $department->id) }}" class="u-ml-4 u-mr-4">
                @if ($department->getAvatar())
                    <img src="{{ $department->getAvatar() }}" alt="" class="avatar-sm text-center organizationIcon bg-white">
                @else
                    <div class="avatar-sm text-center organizationIcon bg-white">
                        <i class="fas fa-building text-primary"></i>
                    </div>
                @endif
            </a>
            <div class="u-ml-4 u-mr-4 align-self-center">
                <a href="{{ route('department.okr', $department->id) }}">
                    <span class="mb-0 font-weight-bold text-black-50">{{ $department->name }}</span>
                </a>
                @if ($department->children->count()>0)
                <a data-toggle="collapse" href="#collapse{{ $department->id }}" role="button"><i class="fas fa-chevron-down pl-2"></i></a>
                @endif
                <br>
                @if ($department->user_id == auth()->user()->id)
                    <a href="{{ route('department.create', $department->id) }}" data-toggle="tooltip" data-placement="bottom" title="新增部門"><i class="fas fa-plus-circle u-margin-4"></i></a>
                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
                    <a href="{{ route('department.edit', $department->id) }}" data-toggle="tooltip" data-placement="bottom" title="編輯部門"><i class="fas fa-edit u-margin-4"></i></a>
                    <a href="#" onclick="document.getElementById('departmentDelete{{ $department->id }}').submit()" data-toggle="tooltip" data-placement="bottom" title="刪除部門"><i class="fas fa-trash-alt"></i></a>
                    <form method="POST" id="departmentDelete{{ $department->id }}" action="{{ route('department.destroy', $department->id) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                    </form>    
                @endif
            </div>
        </div>
        <div class="collapse" id="collapse{{ $department->id }}">
            @foreach ($department->children as $child)
                @include('organization.department.child', ['department'=>$child])
            @endforeach
        </div>
    </div>