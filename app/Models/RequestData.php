<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestData extends Model
{
    use HasFactory;
    public $MerchantID;
    public $PartnerTransactionID;
    public $Username;
    public $CardSerial;
    public $CardPIN;
    public $TelcoServiceCode;
    public $Signature;
    public $FunctionName;
}
