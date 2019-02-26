<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function stock(){
        return $this->hasOne('App\Stock');
    }

    public function order(){
        return $this->hasMany('App\Order');
    }

    public function record(){
        return $this->hasMany('App\Record');
    }
}
