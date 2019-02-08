<?php

namespace App\Traits;

use App\Objective;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\NewObjectiveNotification;
use App\Project;

trait HasObjectiveTrait
{
    /**
     * Returns all objectives for this model.
     */
    public function objectives()
    {
        return $this->morphMany(Objective::class, 'model');
    }

    public function addObjective(Request $request, $model = null)
    {
        $attr['model_id'] = $this->id;
        $attr['model_type'] = get_class($this);
        $attr['title'] = $request->input('obj_title');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');
        $objective = Objective::create($attr);

        if ($model) {
            if (get_class($model) == Project::class) {
                $users = $model->users()->where('user_id', '!=', auth()->user()->id)->get();
            } else {
                $users = $model->users()->where('id', '!=', auth()->user()->id)->get();
            }
            Notification::send($users, new NewObjectiveNotification($model, $objective));
        }

        return $objective;
    }

    public function hasObjectives()
    {
        return count($this->objectives()->get()) ? true : false;
    }

    public function getObjectivesBuilder(Request $request)
    {
        $builder = $this->objectives();
        # 如果有做搜尋則跑此判斷
        if ($request->input('st_date', '') || $request->input('fin_date', '')) {
            # 判斷起始日期搜索是否為空        
            if ($search = $request->input('st_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('finished_at', '>=', $search);
                });
            }
            # 判斷終點日期搜索是否為空        
            if ($search = $request->input('fin_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('started_at', '<=', $search);
                });
            }
            # 判斷使用內建排序與否
            if ($order = $request->input('order', '')) { 
                # 判斷value是以 _asc 或者 _desc 结尾來排序
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # 判斷是否為指定的接收的參數
                    if (in_array($m[1], ['started_at', 'finished_at', 'updated_at'])) {   
                        # 開始排序              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            $now = now()->toDateString();
            $builder->where('started_at', '<=', $now)
                ->where('finished_at', '>=', $now)
                ->orderBy('finished_at');
        }
        return $builder;
    }

    public function getPages(Request $request)
    {
        $builder = $this->getObjectivesBuilder($request);

        $pages = $builder->paginate(4)->appends([
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', '')
        ]);

        return $pages;
    }

    public function getOkrsWithPage(Request $request)
    {
        $okrs = [];
        $pages = $this->getPages($request);
        foreach ($pages as $obj) {
            $okrs[] = [
                "objective" => $obj,
                "keyresults" => $obj->keyresults,
                "actions" => $obj->actions,
                "chart" => $obj->getChart(),
            ];
        }

        return [
            'okrs' => $okrs,
            'pageInfo' => [
                'link' => $pages->render(),
                'totalItem' => $pages->total()
            ]
        ];
    }

    public function countObjective()
    {
        return count($this->objectives);
    }

    public function countKRs()
    {
        $sum = 0;
        foreach ($this->objectives as $objective) {
            $sum += count($objective->keyresults);
        }

        return $sum;
    }

    public function complianceRate()
    {
        $complianceRate = [0, 0, 0, 0];
        $sum = 0;
        foreach($this->objectives as $objective){
            if($objective->getScore()<0.5){
                $complianceRate[0]++;
            }elseif($objective->getScore()<0.75){
                $complianceRate[1]++;
            }elseif($objective->getScore()<1){
                $complianceRate[2]++;
            }else{
                $complianceRate[3]++;
            }
            $sum++;
        }
        foreach($complianceRate as $index=>$item){
            $complianceRate[$index] = $item / $sum; 
        }

        return $complianceRate;
    }
}
