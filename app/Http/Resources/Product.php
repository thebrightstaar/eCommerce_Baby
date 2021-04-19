<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'=> $this->id,
            'price'=>$this->price,
            'discount'=>$this->discount,
            'description'=>$this->description,
            'image_1'=>$this->image_1,
            'image_2'=>$this->image_2,
            'image_3'=>$this->image_3,
            'image_4'=>$this->image_4,
            'image_5'=>$this->image_5,
            'color'=>$this->color,
            'product_name'=>$this->product_name,
            'quantity'=>$this->quantity,
            'id_departmant'=>$this->id_departmant,
            'created at'=>$this->created_at->format('d/m/y'),
            'updated at'=>$this->updated_at->format('d/m/y')

        ];
    }
}
