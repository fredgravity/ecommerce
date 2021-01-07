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

class User extends Model
{
    use SoftDeletes;

    public $timestamps = true; // auto populate the timestamp columns in the db
    protected $fillable = ['username', 'fullname', 'image_path', 'email', 'password', 'city', 'role', 'country_name', 'state_name',
                            'phone', 'vkey', 'verified', 'mailing_list']; // MASS INSERTION OF DATA INTO THE DB
    protected $dates = ['deleted_at'];



    public function order(){
        return $this->hasMany(Order::class);
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }

    public function vendorDetail(){
        return $this->hasOne(VendorDetail::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function userSession(){
        return $this->hasMany(UserSession::class);
    }

    public function transform($data){
        $users = []; //SET UP CATEGORIES ARRAY

        foreach ($data as $field){
            //CARBON FORMAT DATE FROM DB PROPERLY
            $added = new Carbon($field->created_at);
            $updated = new Carbon($field->updated_at);

            array_push($users, [
                'id'           => $field->id,
                'username'     => $field->username,
                'fullname'     => $field->fullname,
                'email'        => $field->email,
                'phone'        => $field->phone,
                'country_name' => $field->country_name,
                'role'         => $field->role,
                'image'         => $field->image_path,
                'added'        => $added->toFormattedDateString(),
                'updated'        => $updated->toFormattedDateString()
            ]);
        }
        return $users;
    }

    public function transformWithDetails($data){
        $users = []; //SET UP CATEGORIES ARRAY

        foreach ($data as $field){
            //CARBON FORMAT DATE FROM DB PROPERLY
            $added = new Carbon($field->created_at);
            $updated = new Carbon($field->updated_at);

            array_push($users, [
                'id'           => $field->id,
                'username'     => $field->username,
                'fullname'     => $field->fullname,
                'email'        => $field->email,
                'phone'        => $field->phone,
                'country_name' => $field->country_name,
                'role'         => $field->role,
                'image'         => $field->image_path,
                'brandname'         => $field->vendorDetail->brand_name,
                'id_card'         => $field->vendorDetail->id_card,
                'cert'         => $field->vendorDetail->business_cert,
                'added'        => $added->toFormattedDateString(),
                'updated'        => $updated->toFormattedDateString()
            ]);
        }
        return $users;
    }

}
?>