<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Interfaces\HasNotifiableInterface;
use App\Interfaces\HasInvitationInterface;
use App\Traits\HasInvitationTrait;


class Action extends Model implements HasMedia, HasNotifiableInterface, HasInvitationInterface
{
    use Commentable, HasMediaTrait, HasInvitationTrait;

    protected $fillable = [
        'user_id',
        'related_kr',
        'priority',
        'isdone',
        'title',
        'content',
        'started_at',
        'finished_at',
    ];
    protected $touches = ['objective'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objective()
    {
        return $this->keyresult->belongsTo(Objective::class);
    }

    public function keyresult()
    {
        return $this->belongsTo('App\KeyResult', 'related_kr');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority', 'priority');
    }

    public function addRelatedFiles()
    {
        $this->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->sanitizingFileName(function ($fileName) {
                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
            })->toMediaCollection();
        });
    }

    public function getRelatedFileNames()
    {
        $file_names = [];

        $media = $this->getMedia();
        foreach ($media as $m) {
            $file_names[] = $m->file_name;
        }

        return $file_names;
    }

    public function getRelatedFiles()
    {
        $files = [];

        $media = $this->getMedia();
        foreach ($media as $m) {
            $files[] = [
                'media_id' => $m->id,
                'name' => $m->file_name,
                'url' => $m->getUrl(),
                'updated_at' => $m->updated_at->format('Y-m-d H:i:s')
            ];
        }

        return $files;
    }

    public function getNotifiable()
    {
        return $this->user;
    }

    public function getHasCommentMessage()
    {
        return 'Action ' . $this->title;
    }

    public function getInviteUrl($userId)
    {
        return route('user.action', $userId);
    }
}
