<?php

namespace App\Http\Controllers\Front;

use App\Models\Plan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::guard('web')->user();
        return view('front.user.dashboard.index', compact('user'));
    }

    /**
     * Show agent dashboard entry point.
     *
     * @return View
     */
    public function agentDashboard(): View
    {
        $agent = Auth::guard('agent')->user();
        return view('front.agent.dashboard.index', compact('agent'));
    }

    /**
     * Show pricing page.
     *
     * @return View
     */
    public function pricing(): View
    {
        $plans = Plan::all();
        return view('front.pages.pricing', compact('plans'));
    }
}
