<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survivor extends Model
{
    protected $fillable = ['name', 'age', 'genre', 'latitude', 'longitude'];

    protected $table = 'survivor';

    public function items() {
        return $this->hasOne('App\Items');
    }
}
