<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class MainController extends Controller
{
    public function main()
    {
        $tasks = Task::all();
        return view('main', compact('tasks'));
    }

    
}
