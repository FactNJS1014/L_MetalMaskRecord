<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InsertMetalMask;

class InsertMetalMaskController extends Controller
{
    public function saveData(Request $request){
        $mask = $request->input('mask');
        $lotsize = intval($mask['lot']);
        $bsheet = floor($mask['blocksheet']);
        // return response()->json($lotsize/$bsheet);
        $shots = $lotsize/$bsheet;

        $result = intval($shots);

        // if (is_numeric($bsheet) && $bsheet != 0) {
        //     $result = $lotsize / $bsheet;
        // } else {
        //     $result = 0; // or handle error appropriately
        // }

        $YM = date('Ym');
        $maskrec = '';

        $findPrevious = DB::table('MM_MSKREC_TBL')
            ->select('MSKREC_ID')
            ->orderBy('MSKREC_ID', 'DESC')
            ->get();

        if (empty($findPrevious[0])) {
            $maskrec = 'MSKREC-' . $YM . '-000001';
        } else {
            $maskrec = AutogenerateKey('MSKREC', $findPrevious[0]->MSKREC_ID);
        }

        // echo $result;
        $insertMask = new InsertMetalMask();
        $insertMask->MSKREC_ID = $maskrec;
        $insertMask->MSKREC_QRID = $mask['scannedResult'];
        $insertMask->MSKREC_MDLCD = $mask['mdlcd'];
        $insertMask->MSKREC_WON = $mask['won'];
        $insertMask->MSKREC_LISTNO = $mask['listno'];
        $insertMask->MSKREC_CUS = $mask['cus'];
        $insertMask->MSKREC_LOTS = $lotsize;
        $insertMask->MSKREC_BLOCKSHEET = $bsheet;
        $insertMask->MSKREC_SHOTS = $result;
        $insertMask->MSKREC_STD = 1;
        $insertMask->MSKREC_LSTDT = date('Y-m-d H:i:s');
        $insertMask->MSKREC_PCBNO = $mask['pcbno'];
        $insertMask->MSKREC_MMNAME = $mask['mskname'];
        $insertMask->MSKREC_PROCS = $mask['procs'];
        $insertMask->MSKREC_REVS = $mask['rev'];
        $insertMask->MSKREC_REFNO = $mask['ref'];
        $insertMask->MSKREC_PRODDATE = $mask['expire_d'];
        $insertMask->MSKREC_VENDOR = $mask['vendor'];
        $insertMask->MSKREC_EMPREC = $mask['empid'];
        // $insertMask->MSKREC_DETAILS = $mask['details'];
        // $insertMask->MSKREC_TYPES = $mask['types'];
        // $insertMask->MSKREC_REMARK = $mask['remark'];

        $insertMask->save();


        return response()->json($insertMask);
    }

    public function addSettingMasks(Request $request){
        $data = $request->input('forms');
        // return response()->json($data);
        $havemask = DB::table('MM_MASTERMSK_TBL')
            ->where('MMST_QRID', $data['qrid'])
            ->first();

        if ($havemask) {
            $update = DB::table('MM_MASTERMSK_TBL')
                ->where('MMST_QRID', $data['qrid'])
                ->update([
                    'MMST_QRID' => $data['qrid'],
                    'MMST_NO' => $data['listno'],
                    'MMST_CUS' => $data['cus'],
                    'MMST_PCBNO' => $data['pcbnum'],
                    'MMST_MSKNAME' => $data['mskname'],
                    'MMST_PROCS' => $data['process'],
                    'MMST_REVS' => $data['revision'],
                    'MMST_REFNO' => $data['ref'],
                    'MMST_PRDDATE' => $data['productdate'],
                    'MMST_VENDOR' => $data['vendor'],
                    'MMST_REMARK' => $data['remark'],
                ]);
            if ($update) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Update Success'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Update Failed'
                ]);
            }

        }else{
            $insert = DB::table('MM_MASTERMSK_TBL')
                ->insert([
                    'MMST_QRID' => $data['qrid'],
                    'MMST_NO' => $data['listno'],
                    'MMST_CUS' => $data['cus'],
                    'MMST_PCBNO' => $data['pcbnum'],
                    'MMST_MSKNAME' => $data['mskname'],
                    'MMST_PROCS' => $data['process'],
                    'MMST_REVS' => $data['revision'],
                    'MMST_REFNO' => $data['ref'],
                    'MMST_PRDDATE' => $data['productdate'],
                    'MMST_VENDOR' => $data['vendor'],
                    'MMST_REMARK' => $data['remark'],
                ]);
            if ($insert) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Insert Success'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insert Failed'
                ]);
            }
        }
    }
}
