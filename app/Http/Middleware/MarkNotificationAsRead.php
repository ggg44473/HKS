<?php

namespace App\Http\Middleware;

use Closure;

class MarkNotificationAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('readNid')) {
            $notification = $request->user()->notifications()->where('id', $request->readNid)->first();
            if($notification) {
                $notification->markAsRead();
            }
        }
        return $next($request);
    }
}
