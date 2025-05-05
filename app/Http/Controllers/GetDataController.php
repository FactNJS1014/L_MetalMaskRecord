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
        $mdl = $request->input('mdlcd');

        // Query the database table using a LIKE clause
        $get_model_code = DB::table('MM_LISTMDL_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_LISTMDL_TBL.LISTMDL_QRID', '=', 'MM_MASTERMSK_TBL.MMST_QRID')
            ->where('LISTMDL_QRID', 'LIKE', '%' . $ref . '%')
            // ->where('LISTMDL_MDLCD', 'LIKE', '%' . $mdl . '%')
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
        $get_won_code = DB::table('VWORLIST')
            ->where('WON', 'LIKE', '%' . $query . '%')
            ->pluck('WON');

        // Return the result as JSON
        return response()->json($get_won_code);
    }

    public function getWono(Request $request)
    {
        // Get the input parameter named 'ref_id'
        $won = $request->input('won');

        // Query the database table using a LIKE clause
        $get_mdl_code = DB::table('VWORLIST')
            ->where('WON', '=', $won)
            ->select('MDLCD', 'BGCD', 'WONQT', 'MDLQTY')
            ->get();

        // Return the result as JSON
        return response()->json($get_mdl_code);
    }

    public function GetChangeData()
    {
        $data = DB::table('VLINE')
            ->where('LINE_SECTION', '=', 'AM')
            ->orderBy('LINE_LIST', 'asc')
            ->get();
        return response()->json($data);
    }

    public function GetModelChange()
    {
        $data = DB::table('MMCHN_MDL_TBL')
            // ->join('MM_LISTMDL_TBL as mdl1', 'MMCHN_MDL_TBL.MMCHANGE_MDLCHN', '=', 'mdl1.LISTMDL_MDLCD')
            // ->join('MM_LISTMDL_TBL as mdl2', 'MMCHN_MDL_TBL.MMCHANGE_PRCS', '=', 'mdl2.LISTMDL_PROCS')
            // ->join('MM_MASTERMSK_TBL', 'mdl1.LISTMDL_QRID', '=', 'MM_MASTERMSK_TBL.MMST_QRID')
            ->get();

        return response()->json($data);
    }


    public function GetPullData(Request $request)
    {
        $code_id = $request->code;
        $pulldata = DB::table('MMCHN_MDL_TBL')
            ->join('MM_MASTERMSK_TBL', 'MMCHN_MDL_TBL.MMCHANGE_BARCODE', '=', 'MM_MASTERMSK_TBL.MMST_QRID')
            ->where('MMCHN_MDL_TBL.MMCHANGE_APPR_STD', '=', '1')
            ->where('MMCHN_MDL_TBL.MMCHANGE_BARCODE', $code_id)
            ->get();

        return response()->json($pulldata);
    }

    public function GetValues()
    {
        $getval = DB::table('MM_MSKREC_TBL')
        
        // ->join('MM_LISTMDL2_TBL as mdl1', 'MM_MSKREC_TBL.MSKREC_MDLCD', '=','mdl1.LISTMDL_MDLCD')    
         
        ->get()
        ;
        return response()->json($getval);
    }

    public function GetChangeHistory(Request $request)
    {
        $mdl = $request->mdl;
        $prcs = $request->prcs;
        $gethistory = DB::table('MMCHN_MDL_TBL')
            ->join('MM_LISTMDL2_TBL as mdl1', 'MMCHN_MDL_TBL.MMCHANGE_MDLCHN', '=', 'mdl1.LISTMDL_MDLCD')
           
            ->where('mdl1.LISTMDL_MDLCD', $mdl)
            ->where('mdl1.LISTMDL_PROCS', $prcs)
            ->get();
        return response()->json($gethistory);
    }

    public function GetListModel()
    {
        $getlistmodel = DB::table('MM_LISTMDL_TBL')->get();
        return response()->json($getlistmodel);
    }

    public function GetListMask()
    {
        $getlistmask = DB::table('MM_MASTERMSK_TBL')
            ->orderBy('MMST_NO', 'asc') // Sort by MMST_QRID in ascending orde
            ->get();
        return response()->json($getlistmask);
    }

    public function SearchlistModels(Request $request)
    {
        $search = $request->input('search');
        $getlistmodel = DB::table('MM_LISTMDL_TBL')
            ->where('LISTMDL_QRID', 'LIKE', '%' . $search . '%')
            ->get();
        return response()->json($getlistmodel);
    }

    public function SearchlistMasks(Request $request)
    {
        $search = $request->input('search');
        $getlistmask = DB::table('MM_MASTERMSK_TBL')
            ->where('MMST_QRID', 'LIKE', '%' . $search . '%')
            ->get();
        return response()->json($getlistmask);
    }
}
