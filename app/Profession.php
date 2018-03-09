<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //protected $table = 'professions'; --> indica la tabla

    //public $timestamps = false; --> indica que no quiere los campos de tiempo

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
