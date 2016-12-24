<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table='companies';
    protected $primaryKey='id';
    public $timestamps=false;
}
