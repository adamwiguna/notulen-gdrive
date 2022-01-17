<?php

namespace App\Http\Controllers\User;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function create(Note $note)
    {
        return view('user.attendance.create', [
            'note' => $note,
        ]);
    }
}
