<?php

namespace App\Http\Controllers\Front;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    /**
     * Display the front-facing homepage.
     *
     * @return View
     */
    public function index(): View
    {
        return view('front.index');
    }

    /**
     * Show the user type selection page.
     *
     * @return View
     */
    public function selectUser(): View
    {
        return view('front.pages.select_user');
    }

    /**
     * Show user dashboard entry point.
     *
     * @return View
     */
    public function userDashboard(): View
    {
        dd('user dashboard');
    }

    /**
     * Show agent dashboard entry point.
     *
     * @return View
     */
    public function agentDashboard(): View
    {
        dd('agent dashboard');
    }
}
