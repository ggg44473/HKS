<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use App\Action;
use App\Objective;
use App\KeyResult;
use App\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ActionRequest;

class ActionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function create(Objective $objective)
    {
        $priorities = Priority::all();
        $user = User::where('id','=',auth()->user()->id)->first();
        $keyresults = KeyResult::where('objective_id','=',$objective->id)->get();
        $data = [
            'user' => $user,
            'keyresults'=>$keyresults,
            'priorities'=>$priorities,
        ];
        return view('actions.create', $data);
    }

    public function store(ActionRequest $request)
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
        
        return redirect()->route('user.okr', auth()->user()->id);
    }

    public function show(Action $action)
    {
        $user = User::where('id','=',auth()->user()->id)->first();
        $files = get_files(storage_path('app/public/actions/'.$action->id)); 
        $data = [
            'user' => $user,
            'action'=>$action,
            'files'=>$files,
        ];
         
        return view('actions.show',$data);
    }

    public function edit(Action $action)
    {
        $priorities = Priority::all();
        $user = User::where('id','=',auth()->user()->id)->first();
        //使用者的krs
        $actions = Action::where('id','=',$action->id)->get();  
        foreach ($actions as $act) {
          $obj_id = $act->keyresult()->getResults()->objective_id;
        }

        $files = get_files(storage_path('app/public/actions/'.$action->id)); 
        $keyresults = KeyResult::where('objective_id','=',$obj_id)->get();
        $data = [
            'user' => $user,
            'actions' => $actions,
            'keyresults' => $keyresults,
            'files'=>$files,
            'priorities'=>$priorities,
        ];
        return view('actions.edit', $data);
    }

    public function update(ActionRequest $request, Action $action)
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
        
        return redirect()->route('user.okr', auth()->user()->id);
    }

    public function destroy(Action $action)
    {
        $action->delete();
        return redirect()->route('user.okr', auth()->user()->id);
    }

    public function destroyFile($id , $file_path)
    {
        Storage::delete('public/actions/'.$id."/".$file_path);
        return redirect()->route('actions.edit', $id);
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
        return redirect()->route('user.okr', auth()->user()->id);
    }


}
