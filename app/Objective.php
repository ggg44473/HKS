<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;
use App\Charts\SampleChart;
use App\Interfaces\HasNotifiableInterface;

class Objective extends Model implements HasNotifiableInterface
{

    use Commentable;

    // protected $table = "objectives"; // $table預設是複數
    // public $timestamps = false; //若要取消時間戳記
    protected $fillable = [ //新增的欄位名稱
        'title',
        'model_id',
        'model_type',
        'started_at',
        'finished_at'
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function keyresults()
    {
        return $this->hasMany(KeyResult::class);
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Action', 'App\KeyResult', 'objective_id', 'related_kr');
    }

    public function keyResultRecords()
    {
        return $this->hasManyThrough('App\KeyResultRecord', 'App\KeyResult', 'objective_id', 'key_results_id');
    }

    public function getChart()
    {
        $datas = $this->getRelatedKrRecord();
        $chart = new SampleChart;
        if (!$datas) {
            $chart->labels([0]);
            $chart->dataset('None', 'line', [0]);
        }
        $chart->title('Kr 達成率變化圖', 22, '#216869', true, "'Helvetica Neue','Helvetica','Arial',sans-serif");
        foreach ($datas as $data) {
            $chart->labels($data['update']);
            $chart->dataset($data['kr_id'], 'line', $data['accomplish']);
        }
        return $chart;
    }
    public function getRelatedKrRecord()
    {
        //宣告
        $merged = collect();
        $kr_record = array();
        $kr_record_array = array();
        // 抓出相關KR歷史紀錄
        $collections = $this->keyResultRecords()->getResults()->groupBy('key_results_id');
        // 算出達成率並存成array(KR_ID，ACV_RATE，UPDATE)
        foreach ($collections as $collection) {
            // 需要達成率合併
            foreach ($collection as $collect) {
                $color = $collect->keyresult->color();
                $merged->push(collect($collect)->merge(['rate' => $collect->accomplishRate()])->toArray());
            }
            $kr_id = $merged->pluck('key_results_id')->first();
            $kr_date = $merged->pluck('updated_at')->all();
            $kr_acop = $merged->pluck('history_confidence')->all();
            $kr_conf = $merged->pluck('rate')->all();
            $merged = collect();
            $kr_record = array('kr_color' => $color, 'kr_id' => $kr_id, 'update' => $kr_date, 'confidence' => $kr_acop, 'accomplish' => $kr_conf);
            array_push($kr_record_array, $kr_record);
        }
        return $kr_record_array;
    }

    public function getNotifiable()
    {
        return $this->model->getNotifiableUser();
    }

    public function getHasCommentMessage()
    {
        return 'Objective ' . $this->title;
    }

    public function getScore()
    {
        $sum = 0;
        $totalWeight = 0;
        foreach ($this->keyresults as $kr) {
            $totalWeight += $kr->weight;
            $sum += $kr->accomplishRate() * $kr->weight;
        }
        if ($totalWeight > 0) return round($sum / $totalWeight, 0);
        else return 0;
    }

}
