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
}
