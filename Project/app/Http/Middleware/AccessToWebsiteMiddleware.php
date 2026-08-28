<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AccessToWebsiteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $username = env('SITE_ACCESS_USER');
        $password = env('SITE_ACCESS_PASS');

        if ($request->getUser() === $username && Hash::check($request->getPassword(), $password))
        {
            return $next($request);
        }

        $headers = ['WWW-Authenticate' => 'Basic realm="Restricted Area"'];
        return response('Unauthorized', Response::HTTP_UNAUTHORIZED, $headers);
    }
}
