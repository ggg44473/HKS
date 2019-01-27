<div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="createProject" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center font-weight-bold"><h5>新增專案</h5></div>
                </div>
                <form method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- 上傳頭像 --}}
                    <div class="row">
                        <div class="col-12 text-center">
                            <input id="imgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                            <img id="avatarImg" class="avatar u-hidden mt-4 mb-0" src="" alt="">
                            <div id="departmentIcon" class="avatar text-center uploadIcon mt-4 mb-0">
                                <i class="fas fa-images text-white"></i>
                                <i class="fas fa-upload text-white"></i>
                            </div>
                        </div>
                    </div>
                    {{-- 專案名稱 --}}    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="project_name">專案名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="project_name" id="project_name" value="" placeholder="請輸入專案名稱" class="form-control {{ $errors->has('project_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- 專案簡介 --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="project_description">專案簡介<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="project_description" id="department_description" value="" placeholder="請輸入專案概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required></textarea>
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
