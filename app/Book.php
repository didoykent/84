<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = ['title', 'description', 'level', 'link'];


    protected $hidden =  ['remember_token'];
}
