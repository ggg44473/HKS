<div class="container">
    <div class="row m-3">
        <div class="col-md-12 text-center">
            <h4>新增 日常行程</h4>
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
        <form method="POST" action="{{ route('calendar.store') }}">
            @csrf
            <div class="form-group col-md-12">
                <label for="title">新增行程</label>
                <input type="text" class="form-control" name="title" id="title" placehoder="輸入行程" required>
            </div>
            <div class="form-group col-md-12">
                <label for="color">選擇顏色</label>
                <input type="color" class="form-control" name="color" id="color" placehoder="選擇顏色" required>
            </div>
            <div class="form-group col-md-12">
                <label for="started_at">起始日</label>
                <input autocomplete="off" class="form-control" name="st_date" id="started_at" value="" required>
            </div>
            <div class="form-group col-md-12 mb-3">
                <label for="finished_at">完成日</label>
                <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" value="" required>
            </div>
            <div class="col-md-12 text-right">
                <button class="btn btn-primary " type="submit" name="submit">新增</button>
            </div>
        </form>
    </div>
</div>
