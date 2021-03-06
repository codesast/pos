<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function order(){
        return $this->hasMany('App\Order');
    }

    public function record(){
        return $this->hasMany('App\Record');
    }
}
