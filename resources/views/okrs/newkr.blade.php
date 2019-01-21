@php
// 因為要辨識Kr的error在哪個O上面，但不知道如何寫進$errors
    $isError =false;
    if(count($errors)>0){
        $isError = $okr['objective']->id == $errors->first('krs_owner');
    }
@endphp

<a class="btn btn-success mb-3 mt-3" data-toggle="collapse" href="#collapse{{ $okr['objective']->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $okr['objective']->id }}">
     <i class="fa fa-plus fa-sm"></i> KR
</a>

<div class="collapse {{ $isError? 'show' : '' }}" id="collapse{{ $okr['objective']->id }}">
    <div class="card card-body mr-md-5">
        <form method="POST" action="{{ route('kr.store') }}">
                @csrf
            <div class="form-row">
                <input type="hidden" class="form-control" name="krs_owner" id="keyresult_owner" value="{{ $okr['objective']->id }}">
                <div class="form-group col-md-12">
                    <label for="keyresult_title">關鍵指標(KeyResult) <strong class="text-danger">{{ $isError ? $errors->first('krs_title') : '' }}</strong>  </label>
                    <input type="text" class="form-control" name="krs_title" id="keyresult_title" value="{{ old('krs_title') }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="keyresult_confidence">達成率 <strong class="text-danger">{{ $isError ? $errors->first('krs_now'): '' }}</strong></label>
                    <input type="text" class="js-range-slider kr-slider" id="keyresult_slider" name="krs_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}"
                        data-min="{{ old('krs_init') ? old('krs_init') : '0' }}"
                        data-max="{{ old('krs_tar') }}"
                        data-from="{{ old('krs_now') ? old('krs_now') : '0' }}"
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_weight">權重  <strong class="text-danger">{{ $isError ? $errors->first('krs_weight'): '' }}</strong> </label>
                    <input type="text" class="js-range-slider" name="krs_weight" value="{{ old('krs_weight') ? old('krs_weight') : '1' }}"
                        data-min="0.1"
                        data-max="2"
                        data-from="{{ old('krs_weight') ? old('krs_weight') : '1' }}"
                        data-step="0.1"
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-3">
                    <label for="keyresult_confidence">信心值 <strong class="text-danger">{{ $isError ? $errors->first('krs_conf'): '' }}</strong></label>
                    <input type="text" class="js-range-slider" name="krs_conf" value="{{ old('krs_conf') ? old('krs_conf') : '5' }}"
                        data-min="0"
                        data-max="10"
                        data-from="{{ old('krs_conf') ? old('krs_conf') : '5' }}"
                        data-step="1" 
                        data-grid= true 
                    />
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_initaial">起始值  <strong class="text-danger">{{ $isError ? $errors->first('krs_init'): '' }}</strong></label>
                    <input type="number" class="form-control kr-init" name="krs_init" id="keyresult_initaial" value="{{ old('krs_init') ? old('krs_init') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label class="text-primary" for="keyresult_target">當前值 <strong class="text-danger">{{ $isError ? $errors->first('krs_now'): '' }}</strong></label>
                    <input type="number" class="form-control kr-now" name="krs_now" id="keyresult_now" value="{{ old('krs_now') ? old('krs_now') : '0' }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="keyresult_target">目標值 <strong class="text-danger">{{ $isError ? $errors->first('krs_tar'): '' }}</strong></label>
                    <input type="number" class="form-control kr-target" name="krs_tar" id="keyresult_target" value="{{ old('krs_tar') ? old('krs_tar') : '100' }}">
                </div>
                <div class="form-group col-md-6 u-text-right">
                    <button class="btn btn-primary u-mt-16" type="submit" style="width:100px;">新增</button>   
                </div>
            </div>
        </form>
    </div>
</div>


