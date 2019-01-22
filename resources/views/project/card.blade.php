<div class="card-body u-pt-32 u-pb-32">
    <div class="row justify-content-center">
        <div class="col-lg-3 text-center">
            <img src="{{ $project->getAvatar() }}" alt="" class="avatar text-center projectAvatar">
        </div>
        <div class="col-lg-7 col-md-10">
            <div class="row justify-content-center u-mb-8">
                <div class="col-lg-6 col-md-7">
                    <h5 class="u-mt-8 u-mb-8 text-black-50 font-weight-bold">{{ $project->name }}</h5>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="pt-2 w-100" style="display:inline-block;">
                        @php
                        $avg = 0;
                        foreach ($project->okrs as $okr) {
                            $sum = 0; $totalWeight = 0;
                            if($project->okrs){
                                foreach($okr['keyresults'] as $kr){
                                $totalWeight += $kr->weight;
                                $sum += $kr->accomplishRate() * $kr->weight;
                                }
                            }
                            if($totalWeight > 0) $scoreOfObj=round($sum/$totalWeight, 0);
                            else $scoreOfObj=0;
                            $avg += $scoreOfObj;
                        }
                        if($avg != 0) $avg /= count($project->okrs);
                        else $avg = 0;
                        @endphp

                        <div class="progress" style="height:20px;">
                            @if($avg<0) 
                                <div class="progress-bar bg-danger" role="progressbar" style="width:{{ abs($avg) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    {{ $avg }}%
                                </div>
                            @else 
                                <div class="progress-bar" role="progressbar" style="width:{{ $avg }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    {{ $avg }}%
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-black-50 description">{{ $project->description }}</span>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <hr class="u-mb-16">
        </div>
    </div>
    @if ($project->okrs)
        @foreach ($project->okrs as $okrs)
            <div class="row justify-content-center mb-2">
                <div class="col-lg-3 text-center">
                    <span class="font-weight-bold text-black-50" style="font-size:14px;">Objective</span>
                </div>
                <div class="col-lg-7 text-black-50 text-center text-lg-left">{{ $okrs['objective']->title }}</div>
            </div>
        @endforeach
    @else
        <div class="row justify-content-center">
            <div class="col-lg-3 text-center mw-100">
                <span class="font-weight-bold text-black-50" style="font-size: 14px;">Objective</span>
            </div>
            <div class="col-lg-7 text-black-50 text-center text-lg-left">尚未具有進行中的Objective
                @if (!($project->okrs))
                    <a href="#" data-toggle="modal" data-target="#objective"><i class="fa fa-plus fa-sm"></i></a>
                @endif
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <hr class="u-mb-16">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 text-right">
            @if ($project->user_id == auth()->user()->id)
            <a href="{{ route('project.done', $project) }}" data-toggle="tooltip" data-placement="bottom" title="{{ $project->isdone?'取消關閉':'關閉專案'}}"><i class="far fa-check-square u-margin-4"></i></a>                    
            <a href="{{ route('project.invite', $project) }}" data-toggle="tooltip" data-placement="bottom" title="新增成員"><i class="fas fa-user-plus u-margin-4"></i></a>
            <a href="{{ route('project.edit', $project) }}" data-toggle="tooltip" data-placement="bottom" title="編輯專案"><i class="fas fa-edit u-margin-4"></i></a>
            <a href="#" onclick="document.getElementById('projectDelete').submit()" data-toggle="tooltip" data-placement="bottom" title="刪除專案"><i class="fas fa-trash-alt"></i></a>
            <form method="POST" id="projectDelete" action="{{ route('project.destroy', $project) }}">
                @csrf
                {{ method_field('DELETE') }}
            </form>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            @include('okrs.create', ['route'=>route('project.objective.store', $project)])
        </div>
    </div>
</div>