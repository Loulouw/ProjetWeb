<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersEpisodes extends Model
{
    protected $table='usersepisodes';
    public $timestamps=false;
    protected $primaryKey='id';
}
