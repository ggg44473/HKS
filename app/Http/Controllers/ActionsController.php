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
        $this->authorize('storeObjective', $objective->model);

        $priorities = Priority::all();
        $user = User::where('id', '=', auth()->user()->id)->first();
        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        if ($keyresults->toArray() == null) return redirect()->route('user.okr', auth()->user()->id);
        $data = [
            'owner' => $user,
            'objective' => $objective,
            'keyresults' => $keyresults,
            'priorities' => $priorities,
        ];
        return view('actions.create', $data);
    }

    public function store(ActionRequest $request)
    {
        $this->authorize('storeObjective', KeyResult::find($request->krs_id)->objective->model);

        $attr['user_id'] = auth()->user()->id;
        $attr['related_kr'] = $request->input('krs_id');
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action = Action::create($attr);
        if ($request->input('invite')) {
            $action->sendInvitation($request);
        }
        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        $objective = $action->objective;
        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
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
        $this->authorize('update', $action);

        $priorities = Priority::all();
        $user = User::where('id', '=', auth()->user()->id)->first();

        //使用者的krs
        $actions = Action::where('id', '=', $action->id)->get();
        foreach ($actions as $act) {
            $obj_id = $act->keyresult->objective_id;
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
        $this->authorize('update', $action);

        if ($request->input('invite') && $request->input('invite') != $action->user_id) {
            $action->sendInvitation($request);
        }

        $attr['related_kr'] = $request->input('krs_id');
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action->update($attr);

        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        $objective = $action->objective;
        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
    }

    public function destroy(Action $action)
    {
        $this->authorize('delete', $action);
        $objective = $action->objective;
        $redirectURL = $objective->model->getOKrRoute();
        $action->invitation()->delete();
        $action->delete();

        return redirect()->to($redirectURL . '#oid-' . $objective->id);
    }

    public function destroyFile(Action $action, Media $media)
    {
        $this->authorize('delete', $action);

        $media->delete();
        return redirect()->route('actions.edit', $action);
    }

    public function done(Action $action)
    {
        $this->authorize('update', $action);

        $act = Action::find($action->id);
        if($act->isdone) $act->isdone = null;
        else $act->isdone = now();
        $act->save();
        return redirect()->back();
    }

    public function search(Objective $objective)
    {
        $results = $objective->model->users;
        return response()->json($results);
    }

    /**
     * 拒絕邀請
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function rejectInvite(Action $action, User $member)
    {
        $action->deleteInvitation($member);
        return redirect()->route('user.action', $member->id);
    }

    /**
     * 同意邀請
     *
     * @param  \App\Project $project
     * @param  \App\User $member
     * @return \Illuminate\Http\Response
     */
    public function agreeInvite(Action $action, User $member)
    {
        $action->deleteInvitation($member);
        $attr['user_id'] = $member->id;
        $action->update($attr);
        return redirect()->route('user.action', $member->id);
    }


}
