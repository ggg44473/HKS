<?php

namespace App\Traits;

use App\Avatar;

trait HasAvatarTrait
{
    /**
     * Returns all avatar for this model.
     */
    public function avatar()
    {
        return $this->morphMany(Avatar::class, 'model');
    }

    public function addAvatar($request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            if ($this->avatar()->first()) {
                $avatar = $this->avatar()->first();
            } else {
                $attr['model_id'] = $this->id;
                $attr['model_type'] = get_class($this);
                $avatar = Avatar::create($attr);
            }
            $avatar->update(['path' => '/storage/avatar/' . $avatar->id . '/' . $filename]);
            $file->storeAs('public/avatar/' . $avatar->id, $filename);
        }
    }

    public function getAvatar()
    {
        if ($this->avatar()->first()) {
            return $this->avatar()->first()->path;
        } else {
            switch (get_class($this)) {
                case 'App\User':
                    return '/img/icon/user/green.png';
                case 'App\Company':
                case 'App\Department':
                    return '/img/icon/building/g.png';
                case 'App\Project':
                    return '/img/icon/project/gc.png';
                case 'App\Action':
                    return '/img/logo/favicon.ico';
            }
        }
    }

    public function deleteAvatar()
    {

    }
}
