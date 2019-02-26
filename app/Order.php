<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function menu(){
        return $this->belongsTo('App\Menu');
    }

    public function table(){
        return $this->belongsTo('App\Table');
    }
    public function delivery_status(){
        return $this->hasOne('App\DeliveryStatus','order_id');
    }
}
