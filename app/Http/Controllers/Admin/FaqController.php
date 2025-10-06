<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $faqs = Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'question' => 'required|string|unique:faqs,question|min:10',
            'answer' => 'required|string|min:10',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Faq $faq
     * @return View
     */
    public function show(Faq $faq): View
    {
        return view('admin.faq.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faq $faq
     * @return View
     */
    public function edit(Faq $faq): View
    {
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $request->validate([
            'question' => 'required|string|min:10|unique:faqs,question,' . $faq->id,
            'answer' => 'required|string|min:10',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }
}
