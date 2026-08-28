<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LimitUserSessions
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }

    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $activeSessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderBy('last_activity', 'desc')
                ->get();

            if ($activeSessions->count() > 2) {
                $sessionsToRemove = $activeSessions->slice(2);
                foreach ($sessionsToRemove as $session) {
                    DB::table('sessions')->where('id', $session->id)->delete();
                }

                $this->logger->logSessionLimitExceeded($user->id, 2);
            }
        }

        return $next($request);
    }
}
