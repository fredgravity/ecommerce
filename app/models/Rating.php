<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 1/26/2019
 * Time: 11:16 AM
 */

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Rating extends Model
{
    use SoftDeletes;

    public $timestamps = true ;
    protected $fillable = ['user_id', 'vendor_id', 'rating', 'product_id'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}



?>