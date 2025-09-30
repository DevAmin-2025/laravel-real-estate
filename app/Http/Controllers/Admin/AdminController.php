<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display the admin panel.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.index');
    }
}
