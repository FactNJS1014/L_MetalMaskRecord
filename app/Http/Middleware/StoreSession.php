<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreSession
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
        // Example: Store session data from query parameters
        if ($request->has('username')) {
            session([
                'username' => $request->query('username'),
                'empno' => $request->query('empno'),
                'department' => $request->query('department'),
                'USE_PERMISSION' => $request->query('USE_PERMISSION'),
                'sec' => $request->query('sec'),
                'MSECT_ID' => $request->query('MSECT_ID'),
            ]);
        }

        return $next($request);
    }
}
