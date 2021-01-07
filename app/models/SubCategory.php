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

class SubCategory extends Model
{
    use SoftDeletes;

    public $timestamps = true; // auto populate the timestamp columns in the db
    protected $fillable = ['name', 'slug', 'category_id']; // MASS INSERTION OF DATA INTO THE DB
    protected $dates = ['deleted_at'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function transform($data){
        //TRANSFORM DATA OBJECT TO ARRAY
        $subcategories = []; //SET UP CATEGORIES ARRAY

        foreach ($data as $field){
            //CARBON FORMAT DATE FROM DB PROPERLY
            $added = new Carbon($field->created_at);

            array_push($subcategories, [
                'id'    => $field->id,
                'name'  => $field->name,
                'category_id'  => $field->category_id,
                'slug'  => $field->slug,
                'added' => $added->toFormattedDateString()
            ]);
        }
        return $subcategories;
    }






}
?>