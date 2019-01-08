<div class="container">
<div class="row">
    <div class="col-12"><h2>修改Objective</h2></div>
    <form method="POST" action="{{route('okr.update',$objective->id)}}">
        @csrf
        {{ method_field('PATCH') }}
        <div class="form-row">
        <div class="form-group col-md-4">
            <label for="objective_title">目標(Objective)</label>
            <input type="text" class="form-control" name="obj_title" id="objective_title" value="{{$objective->title}}" required>
        </div>
        <div class="form-group col-md-4">
            <label for="started_at">起始日</label>
            <input type="date" class="form-control" name="st_date" id="started_at" value="{{$objective->started_at}}" required>
            </div>
        <div class="form-group col-md-4">
            <label for="finished_at">完成日</label>
            <input type="date" class="form-control" name="fin_date" id="finished_at" value="{{$objective->finished_at}}" required>
        </div>
        <button class="btn btn-primary btn-sm col-md-12" type="submit">修改</button>  
        </div>
    </form>
</div>
