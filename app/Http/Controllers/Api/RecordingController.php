<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Student;

class RecordingController extends Controller
{
    public function getFileRecording(Request $request){



    if($request->file('file')){

   Storage::putFile('public', $request->file('file'));

   return response()->json(['Success' => true]);
    }


  }

public function getData(Request $request){

$students = Student::all();

return response()->json(['MyStudents' => $students]);

}
}
