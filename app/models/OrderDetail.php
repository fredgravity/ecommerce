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

class OrderDetail extends Model
{
    use SoftDeletes;

    public $timestamps = true; // auto populate the timestamp columns in the db
    protected $fillable = ['user_id', 'product_id', 'unit_price', 'quantity', 'total', 'status', 'order_id', 'vendor_id']; // MASS INSERTION OF DATA INTO THE DB
    protected $dates = ['deleted_at'];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function transform($data){
        $orders = []; //SET UP CATEGORIES ARRAY

        foreach ($data as $field){
            //CARBON FORMAT DATE FROM DB PROPERLY
            $added = new Carbon($field->created_at);

            array_push($orders, [
                'id'    => $field->id,
                'order_id'  => $field->order_id,
                'user_id' => $field->user_id,
                'product_id' => $field->product_id,
                'unit_price' => $field->unit_price,
                'quantity' => $field->quantity,
                'total' => $field->total,
                'status' => $field->status,
                'added' => $added->toFormattedDateString()
            ]);
        }
        return $orders;
    }

}
?>