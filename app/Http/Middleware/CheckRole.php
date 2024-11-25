<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check() && !$request->user()->hasAnyRole($roles)) {
            return redirect('/error-403');
        }

        return $next($request);
    }
}
