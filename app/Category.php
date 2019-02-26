<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function menu(){
        return $this->hasMany(Menu::class);
    }
}
