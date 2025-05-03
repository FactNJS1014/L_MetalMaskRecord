<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function setSession(Request $request)
    {
        session([
            'username' => $request->get('username'),
            'empno' => $request->get('empno'),
            'department' => $request->get('department'),
            'USE_PERMISSION' => $request->get('USE_PERMISSION'),
            'sec' => $request->get('sec'),
            'MSECT_ID' => $request->get('MSECT_ID'),
        ]);

        return redirect('/45_engmask');
    }
}
