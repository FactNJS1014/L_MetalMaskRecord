<?php

namespace App\Http\Controllers;

use App\Models\ChangeMask;
use App\Models\InsertMetalMask;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsertChangeModelController extends Controller
{
    public function insertChangeModel(Request $request)
    {
        // Get the input parameters from the request
        $data = $request->input('formChange');

        $YM = date('Ym');
        $Change_ID = '';

        $findPrevious = DB::table('MMCHN_MDL_TBL')
            ->select('MMCHANGE_ID')
            ->orderBy('MMCHANGE_ID', 'DESC')
            ->get();

        if (empty($findPrevious[0])) {
            $Change_ID = 'CHNG-' . $YM . '-000001';
        } else {
            $Change_ID = AutogenerateKey('CHNG', $findPrevious[0]->MMCHANGE_ID);
        }

        $changeModel = new ChangeMask();
        $changeModel->MMCHANGE_ID = $Change_ID;
        $changeModel->MMCHANGE_BARCODE = $data['barcode'];
        $changeModel->MMCHANGE_EMPID = $data['empID'];
        $changeModel->MMCHANGE_LINE = $data['line'];
        $changeModel->MMCHANGE_CUS = $data['customer'];
        $changeModel->MMCHANGE_PRCS = $data['process'];
        $changeModel->MMCHANGE_MDL = $data['model'];
        $changeModel->MMCHANGE_WONNO = $data['wonNo'];
        $changeModel->MMCHANGE_SHIFT = $data['shift'];
        $changeModel->MMCHANGE_LSTDT = date('Y-m-d H:i:s');
        $changeModel->MMCHANGE_STD = 1;
        $changeModel->MMCHANGE_MDLCHN = $data['mdlch'];
        // Save the model to the database
        $changeModel->save();

        // return response()->json($data['barcode']);
        return response()->json($changeModel);

    }

    public function saveData(Request $request){
        $mask = $request->input('mask');
        $lotsize = intval($mask['lot']);
        $bsheet = $mask['blocksheet'];
        
        if (is_numeric($bsheet) && $bsheet != 0) {
            $result = $lotsize / $bsheet;
        } else {
            $result = 0; // or handle error appropriately
        }

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
        $insertMask->MSKREC_BLOCKSHEET = $mask['blocksheet'];
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
        $insertMask->MSKREC_DETAILS = $mask['details'];
        $insertMask->MSKREC_TYPES = $mask['types'];
        $insertMask->MSKREC_REMARK = $mask['remark'];
        
        $insertMask->save();

        
        return response()->json($insertMask);
    }
}
