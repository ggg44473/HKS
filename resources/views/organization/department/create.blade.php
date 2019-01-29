<div class="modal fade " id="createDepartment" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center font-weight-bold"><h5>新增部門</h5></div>
                </div>
                <form method="POST" action="{{ route('department.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- 上傳頭像 --}}
                    <div class="row">
                        <div class="col-12 text-center">
                            <input id="imgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                            <img id="avatarImg" class="avatar u-hidden u-margin-16" src="" alt="">
                            <img id="avatarImgUpload" class="avatar u-hidden u-margin-16" src="/img/icon/upload/gray.svg" alt="">
                            <div id="departmentIcon" class="avatar text-center uploadIcon">
                                <i class="fas fa-images text-white"></i>
                                <i class="fas fa-upload text-white"></i>
                            </div>
                        </div>
                    </div>
                    {{-- 部門名稱 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="department_name">部門名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="department_name" id="department_name" value="" placeholder="請輸入部門名稱" class="form-control {{ $errors->has('department_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- 隸屬部門 --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="department_parent">隸屬組織<strong class="invalid-feedback"></strong></label>
                                <select name="department_parent" id="department_parent" class="form-control">
                                    @if ($parent)
                                        <option value="parent{{ $parent->id }}" selected>{{ $parent->name }}</option>
                                    @endif
                                    @if ($self)
                                        <option value="self{{ $self->id }}" selected>{{ $self->name }}</option>
                                    @endif
                                    @foreach ($children as $child)
                                        <option value="department{{ $child->id }}">{{ $child->name }}</option>                                        
                                    @endforeach
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
                                    <textarea type="text" name="department_description" id="department_description" value="" placeholder="請輸入部門概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- 建立按鈕 --}}
                    <div class="form-row u-mt-16 u-mb-32 justify-content-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">建立</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
