<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = ['item', 'water', 'food', 'medicament', 'ammunition', 'survivor_id'];

    public function survivor() {
        return $this->hasOne('App\Survivor');
    }
}
