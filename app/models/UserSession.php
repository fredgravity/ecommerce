<?php
/**
 * Created by PhpStorm.
 * User: gravity
 * Date: 2/7/2019
 * Time: 10:07 AM
 */

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSession extends Model
{

    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['user_id', 'cookie_id', 'cookie_hash', 'user_agent'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }



}





?>