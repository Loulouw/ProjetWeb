<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actors extends Model
{
    protected $table='actors';
    protected $primaryKey='id';
    public $timestamps=false;
}
