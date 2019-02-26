<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function menu(){
        return $this->belongsTo('App\Menu');
    }
}
