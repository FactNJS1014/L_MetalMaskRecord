<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function login(Request $request){
        session([
            'username' => $request->query('username'),
            'empno' => $request->query('empno'),
            'department' => $request->query('department'),
            'USE_PERMISSION' => $request->query('USE_PERMISSION'),
            'sec' => $request->query('sec'),
            'MSECT_ID' => $request->query('MSECT_ID'),
        ]);
    
        return redirect('/'); // Redirect to Vue frontend ("/" route)
    }
}
