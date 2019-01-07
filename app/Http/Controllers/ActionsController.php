<?php

namespace App\Http\Controllers;

use Storage;
use App\Action;
use App\KeyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ActionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function create(KeyResult $keyresult)
    {
        $data = [
            'keyresult'=>$keyresult,
        ];
        return view('actions.create',$data);
    }

    public function store(Request $request)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['related_kr'] = $request->input('krs_id');
        $attr['assignee'] = auth()->user()->id;
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action = Action::create($attr);

        ##上傳檔案##
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach($files as $file){
                $info = [
                    'mime-type' => $file->getMimeType(),
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getClientSize(),
                ];
                $file->storeAs('public/actions/'.$action->id, $info['original_filename']);
            }
        }
        
        return redirect()->route('okrs.index');
    }

    public function show(Action $action)
    {
        
         $files = get_files(storage_path('app/public/actions/'.$action->id)); 
         $data = [
             'action'=>$action,
             'files'=>$files,
         ];
         
         return view('actions.show',$data);
    }

    public function edit(Action $action)
    {
        //使用者的krs
        $actions = Action::where('id','=',$action->id)->get();  
        foreach ($actions as $act) {
          $obj_id = $act->keyreult()->getResults()->objective_id;
        }

        $files = get_files(storage_path('app/public/actions/'.$action->id)); 
        $keyresults = KeyResult::where('objective_id','=',$obj_id)->get();
        $data = [
            'actions' => $actions,
            'keyresults' => $keyresults,
            'files'=>$files,
        ];
        return view('actions.edit',$data);
    }

    public function update(Request $request, Action $action)
    {
        $attr['user_id'] = auth()->user()->id;
        $attr['related_kr'] = $request->input('krs_id');
        $attr['assignee'] = auth()->user()->id;
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action->update($attr);

        ##上傳檔案##
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach($files as $file){
                $info = [
                    'mime-type' => $file->getMimeType(),
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getClientSize(),
                ];
                $file->storeAs('public/actions/'.$action->id, $info['original_filename']);
            }
        }
        
        return redirect()->route('okrs.index');
    }

    public function destroyAct(Action $action)
    {
        $action->delete();
        return redirect()->route('okrs.index');
    }

    public function destroyFile($id , $file_path)
    {
        Storage::delete('public/actions/'.$id."/".$file_path);
        return redirect()->route('actions.show', $id);
    }

    public function download($file,$action_id)
    {
        $file = storage_path('app/public/actions/'.$action_id."/".$file);
        return response()->download($file);
    }

    public function getImg($file_path)
    {
        $file_path = str_replace('&','/',$file_path); //斜線不可以在URL中傳
        $file = File::get($file_path);
        $type = File::mimeType($file_path);

        return response($file)->header("Content-Type", $type);

    }
    public function done(Action $action)
    {
        $act = Action::find($action->id);  
        $act->isdone = 'true';
        $act->save();
        return redirect()->route('okrs.index');
    }


}
