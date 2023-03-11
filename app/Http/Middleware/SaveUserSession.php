<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Session;

class SaveUserSession
{
    public function handle(Request $request, Closure $next)
    {
        $session = Session::where('id', $request->session()->getId())->first();

        if (!$session) {
            $session = new Session;
            $session->user_id = auth()->id();
            $session->id = $request->session()->getId();
            $session->ip_address = $request->ip();
            $session->user_agent = $request->userAgent();
            $session->start_time = now();
        }

        $session->last_activity = now();
        $session->save();

        return $next($request);
    }
}
