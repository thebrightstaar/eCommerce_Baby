<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_product extends Model
{
    use HasFactory;
    protected $fillable = [

        'id_user','id_product',
        'favorite_status','bag_status'
    ];

    public function user(){

        return $this->belongsTo('App\Models\User','id_user');
    }

    public function product(){

        return $this->belongsTo('App\Models\Product','id_product');
    }
}
