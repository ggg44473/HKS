<?php

namespace App\Traits;

use App\Objective;
use Illuminate\Http\Request;

trait HasObjectiveTrait
{
    /**
     * Returns all objectives for this model.
     */
    public function objectives()
    {
        return $this->morphMany(Objective::class, 'model');
    }

    public function addObjective(Request $request)
    {
        $attr['model_id'] = $this->id;
        $attr['model_type'] = get_class($this);
        $attr['title'] = $request->input('obj_title');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        return Objective::create($attr);
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

        $pages = $builder->paginate(5)->appends([
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
                'totalItem' =>$pages->total()
            ]
        ];
    }
}
