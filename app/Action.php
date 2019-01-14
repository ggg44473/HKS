<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Action extends Model implements HasMedia
{

    use Commentable, HasMediaTrait;

    protected $fillable = [
        'user_id',
        'related_kr',
        'assignee',
        'priority',
        'isdone',
        'title',
        'content',
        'started_at',
        'finished_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignee()
    {
        return $this->belongsTo('App\User', 'assignee');
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

    public function getRelatedFiles()
    {
        $files = [];

        $media = $this->getMedia();
        foreach ($media as $m) {
            $files[] = [
                'url' => $m->getUrl(),
                'name' => $m->file_name,
                'media_id' => $m->id
            ];
        }

        return $files;
    }
}
