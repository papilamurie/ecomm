<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = ['filter_name','sort','status'];

    public function values(){
        return $this->hasMany(FilterValue::class);
    }
}
