<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $sessions = Auth::user()->sessions()->where('is_active_session', true)->orderByDesc('created_at')->get();
        return view('user.index', ['sessions' => $sessions]);
    }

    public function store(Request $request){
        $session = new Session();
        $session->user_id = Auth::user()->id;
        $session->ip_address = $request->ip();
        $session->save();

        return redirect()->route('sessions.index');
    }

        public function endSession(Session $session)
        {
            // проверяем, что выбранная сессия принадлежит текущему пользователю
            if ($session->user_id == Auth::user()->id) {
//                $session->delete();
                $session->update([
                    'is_active_session' => false,
                ]);
            }


//            return redirect()->route('sessions.index');
            return back();
        }


    public function endAllSessionsExceptCurrent(Session $session)
    {
        $userId = Auth::id();
        Session::where('user_id', $userId)
            ->where('id', '<>', $session->id)
            ->update([
                'is_active_session' => false,
            ]);

        return back();
    }

    public function EndAllSessions()
    {
        Auth::user()->sessions()->where('is_active_session', true)->update(['is_active_session' => false]);
        return back();
    }


}
