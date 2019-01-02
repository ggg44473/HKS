<?php

namespace App\Http\Controllers;

use App\Objective;
use App\Keyresult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OKRsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //使用者的Obj
        $objectives = Objective::where('owner','=',auth()->user()->id)->orderBy('finished_at')->get();
        //使用者的krs
        $objids = Objective::where('owner','=',auth()->user()->id)->pluck('id');
        $keyresults = Keyresult::whereIn('owner',$objids)->get();

        //個人總達成率
        $item=0;
        $sum=0;
        $avg=0;
        foreach($keyresults as $keyresult){
            $item+=$keyresult->weight;
            $sum+=$keyresult->average*$keyresult->weight;
        }
        if($item>0) $avg = $sum/$item;

        //取用資料的集合
        $data=[
            'objectives'=>$objectives,
            'keyresults'=>$keyresults,
            'average'=>round($avg,1),
        ];
        return view('okrs.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('okrs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $att['owner'] = auth()->user()->id;
        $att['title'] = $request->input('obj_title');
        $att['started_at'] = $request->input('st_date');
        $att['finished_at'] = $request->input('fin_date');

        Objective::create($att);

        return redirect()->route('okrs.index');
    }
    public function store2(Request $request)
    {
        $att['owner'] = $request->input('krs_owner');
        $att['title'] = $request->input('krs_title');
        $att['confidence'] = $request->input('krs_conf');
        $att['initial'] = $request->input('krs_init');
        $att['target'] = $request->input('krs_tar');
        $att['now'] = $request->input('krs_now');
        $att['weight'] = $request->input('krs_weight');
        $att['average'] =abs(round(($att['now']-$att['initial'])*100/($att['target']-$att['initial']),0));

        Keyresult::create($att);
        return redirect()->route('okrs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Objective $objective)
    {
        return view('okrs.show'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        //使用者的krs
        $keyresults = Keyresult::where('owner','=',$objective->id)->get();  
        $data = [
            'objective' => $objective,
            'keyresults'=> $keyresults,
        ];
        return view('okrs.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objective $objective)
    {
        $att['title'] = $request->input('obj_title');
        $att['started_at'] = $request->input('st_date');
        $att['finished_at'] = $request->input('fin_date');
        $objective->update($att);

        $keyresults = Keyresult::where('owner','=',$objective->id)->get();  
        foreach ($keyresults as $keyresult) {
            $att2['title'] = $request->input('krs_title'.$keyresult->id);
            $att2['confidence'] = $request->input('krs_conf'.$keyresult->id);
            $att2['initial'] = $request->input('krs_init'.$keyresult->id);
            $att2['target'] = $request->input('krs_tar'.$keyresult->id);
            $att2['now'] = $request->input('krs_now'.$keyresult->id);
            $att2['weight'] = $request->input('krs_weight'.$keyresult->id);
            $att2['average'] =abs(round(($att2['now']-$att2['initial'])*100/($att2['target']-$att2['initial']),0));
            $keyresult->update($att2);
        }
       
        return redirect()->route('okrs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        //$objids = Objective::where('owner','=',auth()->user()->id)->pluck('id');
        // Keyresult::where('owner','=',$objective->id)->delete();
        $objective->delete();
        return redirect()->route('okrs.index');
    }
    public function destroy2(Keyresult $keyresult)
    {
        $keyresult->delete();
        return redirect()->route('okrs.index');
    }
}
