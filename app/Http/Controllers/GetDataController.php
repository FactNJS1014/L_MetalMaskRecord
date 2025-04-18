<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDataController extends Controller
{
    //Get Data Model Code
    public function getModelCode(Request $request)
    {
        // Get the input parameter named 'ref_id'
        $ref = $request->input('ref_id');

        // Query the database table using a LIKE clause
        $get_model_code = DB::table('MM_LISTMDL_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_LISTMDL_TBL.LISTMDL_QRID', '=', 'MM_MASTERMSK_TBL.MMST_QRID')
            ->where('LISTMDL_QRID', 'LIKE', '%' . $ref . '%')
            ->select('MM_LISTMDL_TBL.*', 'MM_MASTERMSK_TBL.*')
            ->get();

        // Return the result as JSON
        return response()->json($get_model_code);
    }

    public function SearchWon(Request $request)
    {
        // Get the input parameter named 'ref_id'
        $query = $request->input('query');

        // Query the database table using a LIKE clause
        $get_won_code = DB::table('VWORLIST_1Y')
            ->where('WONO', 'LIKE', '%' .$query. '%')
            ->pluck('WONO');

        // Return the result as JSON
        return response()->json($get_won_code);
    }

    public function getWono(Request $request)
    {
        // Get the input parameter named 'ref_id'
        $won = $request->input('won');

        // Query the database table using a LIKE clause
        $get_mdl_code = DB::table('VWORLIST_1Y')
            ->where('WONO', '=', $won)
            ->select('MDLCD','BSGRP')
            ->get();

        // Return the result as JSON
        return response()->json($get_mdl_code);
    }


}
