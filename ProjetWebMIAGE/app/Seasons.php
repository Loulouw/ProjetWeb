<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    protected $table='seasons';
    protected $primaryKey='id';
    public $timestamps=false;
}
