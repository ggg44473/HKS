<div class="modal fade " id="editProject" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center font-weight-bold"><h5>編輯專案</h5></div>
                </div>
                <form method="POST" action="{{ route('project.update', $project) }}" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    {{-- 上傳頭像 --}}
                    <div class="row">
                        <div class="col-12 text-center">
                            <input name="avatar" type="file" class="u-hidden imgUpload" accept="image/*"/>
                            <img class="avatar u-margin-16 avatarImg" src="{{ $project->getAvatar() }}" alt="">
                            <img class="avatar u-hidden u-margin-16 avatarImgUpload" src="/img/icon/upload/gray.svg" alt="">
                        </div>
                    </div>
                    {{-- 專案名稱 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="project_name">專案名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="project_name" id="project_name" value="{{ $project->name }}" placeholder="請輸入專案名稱" class="form-control {{ $errors->has('project_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- 專案簡介 --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="project_description">專案簡介<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="project_description" id="department_description" value="" placeholder="請輸入專案概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required>{{ $project->description }}</textarea>
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
