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
use Spatie\MediaLibrary\Models\Media;

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
        $user = User::where('id', '=', auth()->user()->id)->first();
        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        if ($keyresults->toArray() == null) return redirect()->route('user.okr', auth()->user()->id);
        $data = [
            'owner' => $user,
            'keyresults' => $keyresults,
            'priorities' => $priorities,
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

        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        return redirect()->route('user.okr', auth()->user()->id);
    }

    public function show(Action $action)
    {
        $user = User::where('id', '=', auth()->user()->id)->first();
        $files = $action->getRelatedFiles();
        $data = [
            'user' => $user,
            'action' => $action,
            'files' => $files,
        ];

        return view('actions.show', $data);
    }

    public function edit(Action $action)
    {
        $priorities = Priority::all();
        $user = User::where('id', '=', auth()->user()->id)->first();

        //使用者的krs
        $actions = Action::where('id', '=', $action->id)->get();
        foreach ($actions as $act) {
            $obj_id = $act->keyresult()->getResults()->objective_id;
        }
        $keyresults = KeyResult::where('objective_id', '=', $obj_id)->get();

        $files = $action->getRelatedFiles();

        $data = [
            'user' => $user,
            'actions' => $actions,
            'keyresults' => $keyresults,
            'files' => $files,
            'priorities' => $priorities,
        ];
        return view('actions.edit', $data);
    }

    public function update(ActionRequest $request, Action $action)
    {
        $attr['related_kr'] = $request->input('krs_id');
        // $attr['assignee'] = auth()->user()->id;
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action->update($attr);

        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        return redirect()->route('user.okr', auth()->user()->id);
    }

    public function destroy(Action $action)
    {
        $action->delete();
        return redirect()->back();
    }

    public function destroyFile(Action $action, Media $media)
    {
        $media->delete();
        return redirect()->route('actions.edit', $action);
    }

    public function done(Action $action)
    {
        $act = Action::find($action->id);
        $act->isdone = 'true';
        $act->save();
        return redirect()->back();
    }
}
