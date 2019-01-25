<?php

namespace App\Traits;

use App\Follow;


trait HasFollowTrait
{
    /**
     * Returns all follow for this model.
     */
    public function follower()
    {
        return $this->morphMany(Follow::class, 'model');
    }

    public function following()
    {
        if($this->follower->where('user_id', auth()->user()->id)->first()) return true ;
        else return false;
    }

    public function delete()
    {
        $this->follower()->delete();
        return parent::delete();
    }
}
