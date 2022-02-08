<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigFavourite extends Model
{
    use HasFactory;
    protected $guarded = ['id','_token'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function gig(){
        return $this->belongsTo(Gig::class);
    }
}
