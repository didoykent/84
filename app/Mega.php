<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class Mega extends Model implements AuthenticatableContract
{
  use Authenticatable;


   protected $table = 'mega';


  protected $fillable = ['en_name', 'kr_name', 'email', 'password', 'role', 'chatroute', 'conn_id', 'latestmessage', 'tutor_id', 'student_id', 'my_tutors_id', 'my_students_id', 'teacher_name', 'teacher_idx', 'student_idx', 'idx',  'passkey', 'avatar'];



  protected $hidden = ['password', 'remember_token'];

  protected $casts = [
       'my_tutors_id' => 'array',
       'my_students_id' => 'array'
   ];

  public function message(){

    return $this->hasMany(Message::class);
  }
}
