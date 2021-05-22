<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paid extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'image', 'address', 'discount_id', 'price', 'status', 'orders'];

    /**
     * The roles that belong to the Paid
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
