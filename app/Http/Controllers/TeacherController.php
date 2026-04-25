<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function directory()
    {
        return view('teacher.directory');
    }

    public function schedule()
    {
        return view('teacher.schedule');
    }

    public function performance()
    {
        return view('teacher.performance');
    }

}
