<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id','_token'];

    public function scopeGetSellerOrder($query,$user)
    {
        return $query->where('seller_id',$user->id);
    }

    public function scopeOrderStatus($query,$status)
    {
        return $query->where('status',$status);
    }

    public function scopeOrderApproved($query)
    {
        return $query->where('status','approved');
    }
}
