<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApproveChange;

class UpdateDataController extends Controller
{
    public function updateApr(Request $request){
        $id = $request->id;
        $aprchng = $request->input('formapr');

        $changeapr = ApproveChange::find($id);

        if($changeapr){
            $changeapr->MMCHANGE_DETAILS = $aprchng['aprremark'];
            $changeapr->MMCHANGE_APPR_STD = 1;
            $changeapr->MMCHANGE_APPR_EMPID = $aprchng['empid'];
            $changeapr->save();

        }

        return response()->json($changeapr);
    }
}
