<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index');
    }
}
