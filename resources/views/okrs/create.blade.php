<div class="container">
    <div class="row m-3">
        <div class="col-12 text-center">
            <h4>新增 Objective</h4>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible col-md-10" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>警告！</strong> 請修正以下表單錯誤：
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="col-12">
            <form method="POST" action="{{ $route }}">
                @csrf
                <div class="form-group">
                    <label for="objective_title">目標</label>
                    <input type="text" class="form-control" name="obj_title" id="objective_title" value="" required>
                </div>
                <div class="form-group">
                    <label for="started_at">起始日</label>
                    <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="" required>
                    </div>
                <div class="form-group mb-3">
                    <label for="finished_at">完成日</label>
                    <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="" required>
                </div>
                <div class="text-right mb-4">
                    <button class="btn btn-primary " type="submit">新增</button>
                </div>
            </form>
        </div>
    </div>
</div>

