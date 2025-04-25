<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyMaskRec extends Model
{
    use HasFactory;
    protected $table = 'MM_MSKREC_TBL';
    protected $primaryKey = 'MSKREC_MDLCD';
    public $timestamps = false;
    protected $fillable = [
        'MSKREC_NOTIFY_STD',
        'MSKREC_MDLCD',
    ];
    protected $keyType = 'string';
    public $incrementing = false;
}
