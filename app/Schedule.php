<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Tutor;
class Schedule extends Model
{


  public function user(){


    return $this->belongsTo(User::class);


  }

  public function tutor(){

    return $this->belongsTo(Tutor::class);
  }
}
