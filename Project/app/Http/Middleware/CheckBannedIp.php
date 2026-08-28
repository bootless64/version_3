<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\BannedIp;
use Illuminate\Http\Request;

class CheckBannedIp
{
    public function handle(Request $request, Closure $next)
    {
        if (BannedIp::isBanned($request->ip())) {
            abort(403, 'دسترسی شما به این سایت مسدود شده است.');
        }

        return $next($request);
    }
}
