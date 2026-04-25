<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function enrollment(){
        return view('student.enrollment');
    }

    public function attend()
    {
        return view('student.attendance');
    }

    public function grade()
    {
        return view('student.grade');
    }

}
