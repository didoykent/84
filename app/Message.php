<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mega;
class Message extends Model
{
    protected $table = 'messages';


    protected $fillable = ['message', 'avatar', 'name', 'tutors_id', 'student_id', 'read', 'from_student', 'from_tutor', 'type'];


    protected $hidden = ['remember_token'];


public function mega(){


  return $this->belongsTo(Mega::class);
}
}
