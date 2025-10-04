<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $items = WhyChooseUs::all();
        return view('admin.why_choose_us.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.why_choose_us.create');
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
            'icon' => 'required|string',
            'title' => 'required|string|unique:why_choose_us,title',
            'text' => 'required|string|min:10',
        ]);

        WhyChooseUs::create([
            'icon' => $request->icon,
            'title' => ucwords($request->title),
            'text' => $request->text,
        ]);
        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WhyChooseUs $item
     * @return View
     */
    public function edit(WhyChooseUs $item): View
    {
        return view('admin.why_choose_us.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WhyChooseUs $item
     * @return RedirectResponse
     */
    public function update(Request $request, WhyChooseUs $item): RedirectResponse
    {
        $request->validate([
            'icon' => 'required|string',
            'title' => 'required|string|unique:why_choose_us,title,' . $item->id,
            'text' => 'required|string|min:10',
        ]);

        $item->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WhyChooseUs $item
     * @return RedirectResponse
     */
    public function destroy(WhyChooseUs $item): RedirectResponse
    {
        $item->delete();
        return redirect()->route('admin.why-choose-us.index')->with('success', 'Item deleted successfully.');
    }
}
