<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id','_token'];
    public function scopeParentIdNull($query){
        return $query->whereNull('parent_id');
    }

    public function scopeChildCategories($query,$parentId){
        return $query->whereNotNull('parent_id')->where('parent_id',$parentId);
    }
}
