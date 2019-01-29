<div class="modal fade " id="editDepartment" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center font-weight-bold"><h5>編輯部門</h5></div>
                </div>
                <form method="POST" action="{{ route('department.update', $department->id) }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    {{-- 上傳頭像 --}}
                    <div class="row">
                        <div class="col-12 text-center">
                            <input id="imgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                            @if ($department->avatar)
                                <img id="avatarImg" class="avatar u-margin-16" src="{{ $department->getAvatar() }}" alt="">
                                <img id="avatarImgUpload" class="avatar u-hidden u-margin-16" src="/img/icon/upload/gray.svg" alt="">
                            @else
                                <div id="departmentIcon" class="avatar text-center departmentIcon">
                                    <i class="fas fa-images text-white"></i>
                                    <i class="fas fa-upload text-white"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- 部門名稱 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="department_name">部門名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="department_name" id="department_name" value="{{ $department->name }}" placeholder="請輸入部門名稱" class="form-control {{ $errors->has('department_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- 隸屬部門 --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="department_parent">隸屬組織<strong class="invalid-feedback"></strong></label>
                                <select name="department_parent" id="department_parent" class="form-control">
                                    @if ($department->parent)
                                        <option value="department{{ $department->parent->id }}" selected>{{ $department->parent->name }}</option>
                                        @foreach ($department->parent->children as $child)
                                            @if ($child->id != $department->id)
                                                <option value="department{{ $child->id }}">{{ $child->name }}</option>                                                                                        
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="company{{ $department->company->id }}" selected>{{ $department->company->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- 部門簡介 --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="department_description">部門概述<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="department_description" id="department_description" placeholder="請輸入部門概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required>{{ $department->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 建立按鈕 --}}
                    <div class="form-row u-mt-16 u-mb-32 justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">修改</button>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
