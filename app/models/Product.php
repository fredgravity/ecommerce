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

class Product extends Model
{
    use SoftDeletes;

    public $timestamps = true; // auto populate the timestamp columns in the db
    protected $fillable = ['user_id', 'user_role', 'name', 'price', 'description', 'category_id', 'sub_category_id', 'image_path', 'quantity']; // MASS INSERTION OF DATA INTO THE DB
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rating(){
        return $this->hasMany(Rating::class);
    }

    public function transform($data){
        $products = []; //SET UP CATEGORIES ARRAY

        foreach ($data as $field){
            //CARBON FORMAT DATE FROM DB PROPERLY
            $added = new Carbon($field->created_at);

            array_push($products, [
                'id'           => $field->id,
                'name'         => $field->name,
                'price'         => $field->price,
                'description'  => $field->description,
                'quantity'  => $field->quantity,
                'category_id'  => $field->category_id,
                'category_name'  => Category::where('id', $field->category_id)->first()->name,
                'sub_category_id'  => $field->sub_category_id,
                'sub_category_name'  => SubCategory::where('id', $field->sub_category_id)->first()->name,
                'image_path'  => $field->image_path,
                'added' => $added->toFormattedDateString()
            ]);
        }
        return $products;
    }






}
?>