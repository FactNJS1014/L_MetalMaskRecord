<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetDataController extends Controller
{
    //Get Data Model Code
    public function getModelCode(Request $request)
    {
        $ref = $request->input('ref_id');
        $ref_ct = explode('_', $ref);
        $rev = end($ref_ct); // จะได้ค่าตำแหน่งสุดท้ายของ array ไม่ว่าจะมีกี่ตำแหน่ง
        // return response()->json($rev);
        $prcs = $request->input('prcs');



        // Query the database table using a LIKE clause
        $get_model_code = DB::table('MM_LISTMDL2_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_LISTMDL2_TBL.LISTMDL_GRPPCB', '=', 'MM_MASTERMSK_TBL.MMST_PCBNO')
            ->where('MMST_REFNO', 'LIKE', '%' . $rev . '%')
            ->where(function ($query) use ($prcs) {
                $query->where('MMST_PROCS', '=', $prcs)
                    ->orWhere('MMST_PROCS', 'LIKE', $prcs . '/%')
                    ->orWhere('MMST_PROCS', 'LIKE', '%/' . $prcs)
                    ->orWhere('MMST_PROCS', 'LIKE', '%/' . $prcs . '/%');
            })
            ->select('MM_LISTMDL2_TBL.*', 'MM_MASTERMSK_TBL.*')
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
            ->where('MMCHANGE_STD', '=', '1')
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
        $data = DB::table('MM_MSKREC_TBL as msk')
            ->join('MMCHN_MDL_TBL as chn', 'msk.MSKREC_WON', '=', 'chn.MMCHANGE_WONNO')
            ->join('MM_MASTERMSK_TBL as msk2', 'msk.MSKREC_LISTNO', '=', 'msk2.MMST_NO')
            ->join('VUSER_WEB as vw', 'chn.MMCHANGE_EMPID','=', 'vw.MUSR_ID')
            // ->join('VUSER_WEB as vw', 'msk.MSKREC_EMPREC', '=', 'vw.MUSR_ID')
            ->select('chn.*', 'msk.*','msk2.MMST_QRID','msk2.MMST_NO','vw.MUSR_NAME') // You can customize columns here
            ->orderBy('chn.MMCHANGE_ID', 'ASC')
            ->get();

        return response()->json($data);
    }
    public function GetValues2()
    {
        $getval = DB::table('MM_MSKREC_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_MSKREC_TBL.MSKREC_LISTNO', '=', 'MM_MASTERMSK_TBL.MMST_NO')
            ->select('MM_MASTERMSK_TBL.MMST_QRID', 'MM_MSKREC_TBL.*')
            // ->join('MM_LISTMDL2_TBL as mdl1', 'MM_MSKREC_TBL.MSKREC_MDLCD', '=','mdl1.LISTMDL_MDLCD')

            ->get();
        return response()->json($getval);
    }
    public function GetUserName()
    {
        $getuser = DB::table('VUSER_WEB')
            ->select('MUSR_NAME', 'MUSR_ID')
            ->get();
        return response()->json($getuser);
    }

    public function GetChangeHistory(Request $request)
    {
        $mdl = $request->mdl;
        $prcs = $request->prcs;
        $gethistory = DB::table('MMCHN_MDL_TBL')
            ->join('MM_LISTMDL2_TBL as mdl1', 'MMCHN_MDL_TBL.MMCHANGE_MDLCHN', '=', 'mdl1.LISTMDL_MDLCD')

            ->where('mdl1.LISTMDL_MDLCD', $mdl)
            ->where('mdl1.LISTMDL_PROCS', $prcs)
            ->where('MMCHN_MDL_TBL.MMCHANGE_STD', '=', 1)
            ->get();
        return response()->json($gethistory);
    }

    public function GetListModel()
    {
        $getlistmodel = DB::table('MM_LISTMDL2_TBL')->get();
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
        $getlistmodel = DB::table('MM_LISTMDL2_TBL')
            ->where('LISTMDL_MDLCD', 'LIKE', '%' . $search . '%')
            ->get();
        return response()->json($getlistmodel);
    }

    public function SearchlistMasks(Request $request)
    {
        $search = $request->input('search');
        $getlistmask = DB::table('MM_MASTERMSK_TBL')
            ->where('MMST_NO', 'LIKE', '%' . $search . '%')
            ->get();
        return response()->json($getlistmask);
    }

    public function getShowCode(Request $request)
    {
        // Get the input parameter named 'ref_id'
        $ref = $request->input('ref_id');
        $prcs = $request->input('prcs');

        // Query the database table using a LIKE clause
        $get_model_code = DB::table('MM_LISTMDL2_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_LISTMDL2_TBL.LISTMDL_GRPPCB', '=', 'MM_MASTERMSK_TBL.MMST_PCBNO')
            ->where('MM_MASTERMSK_TBL.MMST_NO', $ref)
            ->where(function ($query) use ($prcs) {
                $query->where('MM_MASTERMSK_TBL.MMST_PROCS', '=', $prcs)
                    ->orWhere('MM_MASTERMSK_TBL.MMST_PROCS', 'LIKE', $prcs . '/%')
                    ->orWhere('MM_MASTERMSK_TBL.MMST_PROCS', 'LIKE', '%/' . $prcs)
                    ->orWhere('MM_MASTERMSK_TBL.MMST_PROCS', 'LIKE', '%/' . $prcs . '/%');
            })
            // ->where('LISTMDL_MDLCD', 'LIKE', '%' . $mdl . '%')
            ->select('MM_LISTMDL2_TBL.*', 'MM_MASTERMSK_TBL.*')
            ->get();

        // Return the result as JSON
        return response()->json($get_model_code);
    }

    public function GetIssueNo()
    {
        $YM = date('Ym');
        $issue_no = '';

        $findPrevious = DB::table('MMCHN_MDL_TBL')
            ->select('MMCHANGE_ID')
            ->orderBy('MMCHANGE_ID', 'DESC')
            ->get();

        if (empty($findPrevious[0])) {
            $issue_no = 'MTM-' . $YM . '-000001';
        } else {
            $issue_no = AutogenerateKey('MTM', $findPrevious[0]->MMCHANGE_ID);
        }
        return response()->json($issue_no);
    }

    public function GetListModel2(Request $request)
    {
        $get_model_code = DB::table('MM_LISTMDL2_TBL')
            ->join('MM_MASTERMSK_TBL', 'MM_LISTMDL2_TBL.LISTMDL_GRPPCB', '=', 'MM_MASTERMSK_TBL.MMST_PCBNO')
            // ->where('MMST_NO', $ref)
            // ->where('LISTMDL_MDLCD', 'LIKE', '%' . $mdl . '%')
            ->select('MM_LISTMDL2_TBL.*', 'MM_MASTERMSK_TBL.*')
            ->get();
        return response()->json($get_model_code);
    }

    public function GetEditData(Request $request)
    {
        $maskno = $request->code;
        $getdata = DB::table('MM_MASTERMSK_TBL')
            ->where('MMST_NO', $maskno)
            ->get();

        return response()->json($getdata);
    }

    public function GetProcess(Request $request)
    {
        $mdl = $request->input('mdl');
        $getprocess = DB::table('MM_LISTMDL2_TBL')
            ->where('LISTMDL_MDLCD', $mdl)
            ->select('LISTMDL_PROCS')
            ->get();

        return response()->json($getprocess);
    }
    public function GetEditModel(Request $request)
    {
        $mdl = $request->input('code');
        $procs = $request->input('process');
        $getmodel = DB::table('MM_LISTMDL2_TBL')
            ->where('LISTMDL_MDLCD', $mdl)
            ->where('LISTMDL_PROCS', $procs)
            ->get();

        return response()->json($getmodel);
    }

    public function SearchLINE(Request $request)
    {
        $searchLine = $request->input('searchLine');

        $getFilterLine = DB::table('MM_MSKREC_TBL as msk')
            ->join('MMCHN_MDL_TBL as chn', 'msk.MSKREC_WON', '=', 'chn.MMCHANGE_WONNO')
            ->join('MM_MASTERMSK_TBL as msk2', 'msk.MSKREC_LISTNO', '=', 'msk2.MMST_NO')
            ->select('chn.*', 'msk.*','msk2.MMST_QRID','msk2.MMST_NO') // You can customize columns here
            ->where('chn.MMCHANGE_LINE', '=', $searchLine)

            ->get();


        return response()->json($getFilterLine);
    }

    public function SearchDATE(Request $request)
    {
        $searchDate = $request->input('searchDate');

        $getFilterDate = DB::table('MM_MSKREC_TBL as msk')
            ->join('MMCHN_MDL_TBL as chn', 'msk.MSKREC_WON', '=', 'chn.MMCHANGE_WONNO')
            ->join('MM_MASTERMSK_TBL as msk2', 'msk.MSKREC_LISTNO', '=', 'msk2.MMST_NO')
            ->select('chn.*', 'msk.*','msk2.MMST_QRID','msk2.MMST_NO') // You can customize columns here
            ->whereDate('chn.MMCHANGE_DATE', '=', $searchDate)

            ->get();
        return response()->json($getFilterDate);
    }
}
