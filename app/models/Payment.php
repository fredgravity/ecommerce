<?php
/**
 * Created by PhpStorm.
 * User: Gravity
 * Date: 07/08/2018
 * Time: 9:14 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Payment extends Model
{
    use SoftDeletes;

    public $timestamps = true; // auto populate the timestamp columns in the db
    protected $fillable = ['user_id', 'invoice_id', 'amount', 'status', 'vendor_id']; // MASS INSERTION OF DATA INTO THE DB
    protected $dates = ['deleted_at'];





}
?>