<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        return view('component.timetable');
    }

    public function exams()
    {
        return view('component.exams');
    }

    public function fee()
    {
        return view('component.fees');
    }

    public function library()
    {
        return view('component.library');
    }

}
