<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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


        // รายการ key ที่จะเก็บใน session
        $keys = ['username', 'empno', 'department', 'USE_PERMISSION', 'sec', 'MSECT_ID'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                session([$key => $request->query($key)]);
            }
        }

        // ถ้ายังไม่มี username ใน session หลังจากเช็คและเซตแล้ว → แสดง 404
        if (!session()->has('username') || empty(session('username'))) {
            throw new NotFoundHttpException(); // ส่งไปยังหน้า 404
        }

        return $next($request);
    }
}
