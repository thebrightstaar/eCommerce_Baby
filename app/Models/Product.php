<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable =[
        'name','slug','short_description','description',
        'price','SKU','stock_status','featured','quantity','image_1','image_2',
        'image_3','image_4','image_5','color','category_id'];


    public function product(){

        return $this->belongsTo('App\Models\Category','category_id');
    }
}
