<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveChange extends Model
{
    use HasFactory;
    protected $table = 'MMCHN_MDL_TBL';
    protected $primaryKey = 'MMCHANGE_ID';
    public $timestamps = false;
    protected $fillable = [
        'MMCHANGE_DETAILS',
        'MMCHANGE_APPR_STD',
        'MMCHANGE_APPR_EMPID',

    ];
}
