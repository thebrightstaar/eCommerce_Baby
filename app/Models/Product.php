<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'price', 'discount','description',
        'image_1', 'image_2','image_3',
        'image_4','image_5','color',
        'quantity','product_name','id_departmant'
   ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department','id_departmant');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }

    public function product(){

        return $this->hasMany('App\Models\User_product','id_product');
    }
}
