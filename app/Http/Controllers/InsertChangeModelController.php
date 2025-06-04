<?php

namespace App\Http\Controllers;

use App\Models\ChangeMask;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InsertChangeModelController extends Controller
{
    public function insertChangeModel(Request $request)
    {
        try {
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

            Log::info("Generated Change_ID: " . $Change_ID);

            $changeModel = new ChangeMask();
            $changeModel->MMCHANGE_ID = $Change_ID;
            $changeModel->MMCHANGE_EMPID = $data['empID'];
            $changeModel->MMCHANGE_LINE = $data['line'];
            $changeModel->MMCHANGE_CUS = $data['customer'];
            $changeModel->MMCHANGE_PRCS = $data['process'];
            $changeModel->MMCHANGE_WONNO = $data['wonNo'];
            $changeModel->MMCHANGE_SHIFT = $data['shift'];
            $changeModel->MMCHANGE_LSTDT = date('Y-m-d H:i:s');
            $changeModel->MMCHANGE_STD = 1;
            $changeModel->MMCHANGE_MDLCHN = $data['mdlch'];
            $changeModel->MMCHANGE_ISSUE = $data['issue'];

            $changeModel->save();

            Log::info("Inserted ChangeMask data", $changeModel->toArray());

            return response()->json($changeModel);
        } catch (\Exception $e) {
            Log::error('Error in insertChangeModel: ' . $e->getMessage() .
                ' on line ' . $e->getLine() .
                ' in file ' . $e->getFile());

            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดขณะบันทึกข้อมูล',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    public function addSettingModels(Request $request)
    {
        $data = $request->input('formf');
        // return response()->json($data);

        $havemodel = DB::table('MM_LISTMDL2_TBL')
            ->where('LISTMDL_MDLCD', $data['model'])
            ->where('LISTMDL_PROCS', $data['procs'])
            ->first();
        if ($havemodel) {
            $update = DB::table('MM_LISTMDL2_TBL')
                ->where('LISTMDL_MDLCD', $data['model'])
                ->where('LISTMDL_PROCS', $data['procs'])
                ->update([
                    'LISTMDL_MDLCD' => $data['model'],
                    'LISTMDL_GRPPCB' => $data['pcbno'],
                    'LISTMDL_PROCS' => $data['procs'],
                    'LISTMDL_MSKNO1' => $data['nofirst'],
                    'LISTMDL_MSKNO2' => $data['nosecond'],
                    'LISTMDL_MSKNO3' => $data['nothird'],
                    'LISTMDL_MSKNO4' => $data['nofourth'],
                    'LISTMDL_QRID' => $data['codeid'],
                    'LISTMDL_STD' => 1,
                    'LISTMDL_LSTDT' => date('Y-m-d H:i:s'),

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
        } else {
            $insert = DB::table('MM_LISTMDL2_TBL')
                ->insert([
                    'LISTMDL_MDLCD' => $data['model'],
                    'LISTMDL_GRPPCB' => $data['pcbno'],
                    'LISTMDL_PROCS' => $data['procs'],
                    'LISTMDL_MSKNO1' => $data['nofirst'],
                    'LISTMDL_MSKNO2' => $data['nosecond'],
                    'LISTMDL_MSKNO3' => $data['nothird'],
                    'LISTMDL_MSKNO4' => $data['nofourth'],
                    'LISTMDL_QRID' => $data['codeid'],
                    'LISTMDL_STD' => 1,
                    'LISTMDL_LSTDT' => date('Y-m-d H:i:s'),
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
