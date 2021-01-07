<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 12/8/2018
 * Time: 8:34 AM
 */

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class VendorDetail extends Model
{

    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['user_id', 'id_card', 'business_cert', 'approval', 'brand_name'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}



?>