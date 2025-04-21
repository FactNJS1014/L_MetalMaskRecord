<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeMask extends Model
{
    use HasFactory;
    protected $table = 'MMCHN_MDL_TBL';
    protected $primaryKey = 'MMCHANGE_ID';
    public $timestamps = false;
    protected $fillable = [
        'MMCHANGE_ID',
        'MMCHANGE_BARCODE',
        'MMCHANGE_EMPID',
        'MMCHANGE_LINE',
        'MMCHANGE_CUS',
        'MMCHANGE_PRCS',
        'MMCHANGE_MDL',
        'MMCHANGE_WONNO',
        'MMCHANGE_SHIFT',
        'MMCHANGE_LSTDT',
        'MMCHANGE_STD',
        'MMCHANGE_MDLCHN'

    ];

}
