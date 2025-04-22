<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsertMetalMask extends Model
{
    use HasFactory;
    protected $table = 'MM_MSKREC_TBL';
    protected $primaryKey = 'MSKREC_ID';
    public $timestamps = false;
    protected $fillable = [
        'MSKREC_ID',
        'MSKREC_QRID',
        'MSKREC_MDLCD',
        'MSKREC_WON',
        'MSKREC_LISTNO',
        'MSKREC_CUS',
        'MSKREC_PCBNO',
        'MSKREC_MMNAME',
        'MSKREC_PROCS',
        'MSKREC_REVS',
        'MSKREC_REFNO',
        'MSKREC_PRODDATE',
        'MSKREC_LOTS',
        'MSKREC_SHOTS',
        'MSKREC_EMPID', 
        'MSKREC_VENDOR',
        'MSKREC_REMARK',
        'MSKREC_DETAILS',
        'MSKREC_TYPES',
        // 'MSKREC_EMPREC',
        'MSKREC_STD',
        'MSKREC_LSTDT',
        'MSKREC_BLOCKSHEET'
    ];
}
