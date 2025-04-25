<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApproveChange;
use App\Models\NotifyMaskRec;

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

    public function updateNotiStatus(Request $request){
        $mdl = $request->mdl;
        $noti = NotifyMaskRec::find($mdl);
        if($noti){
            $noti->MSKREC_NOTIFY_STD = 1;
            $noti->save();
        }
        return response()->json($noti);
    
    }
}
