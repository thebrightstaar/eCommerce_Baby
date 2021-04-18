<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['id_user','id_product'];

     public function product()
    {
        return $this->hasMany('App\Models\Product','id_departmant');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User' ,'id_user' );

    }
}
