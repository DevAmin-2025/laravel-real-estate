<?php

namespace App\Http\Controllers\Front;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function index(): View
    {
        return view('front.index');
    }

    public function selectUser(): View
    {
        return view('front.pages.select_user');
    }

    public function userDashboard()
    {
        dd('user dashboard');
    }
}
