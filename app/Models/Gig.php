<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;
    protected $guarded = ['id','_token'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function packages(){
        return $this->hasMany(GigPackage::class);
    }
    public function requirements(){
        return $this->hasMany(GigRequirement::class);
    }

    public function tags(){
        return $this->hasMany(GigTag::class);
    }
}
