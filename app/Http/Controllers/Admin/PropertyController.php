<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $properties = Property::with('location', 'propertyType', 'agent')->get();
        return view('admin.property.index', compact('properties'));
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return View
     */
    public function show(Property $property): View
    {
        $property->load('amenities');
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        $propertyVideos = PropertyVideo::where('property_id', $property->id)->get();
        return view('admin.property.show', compact('property', 'propertyPhotos', 'propertyVideos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     * @return View
     */
    public function edit(Property $property): View
    {
        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        $propertyVideos = PropertyVideo::where('property_id', $property->id)->get();
        return view(
            'admin.property.edit',
            compact(
                'property',
                'locations',
                'propertyTypes',
                'amenities',
                'propertyPhotos',
                'propertyVideos',
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        $request->merge([
            'price' => str_replace(',', '', $request->price),
            'size' => str_replace(',', '', $request->size),
            'floor' => str_replace(',', '', $request->floor),
        ]);

        $request->validate([
            'name' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'type_id' => 'required|exists:property_types,id',
            'purpose' => 'required|string',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'size' => 'required|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'garage' => 'nullable|integer|min:0',
            'balcony' => 'nullable|integer|min:0',
            'address' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'map' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'featured_photo' => 'nullable|image|max:2048',
        ]);

        $newPhoto = $request->file('featured_photo');
        $fileName = '';
        if ($newPhoto) {
            $currentFeaturedPhoto = $property->featured_photo;
            $fileName = Carbon::now()->micro . '-' . $request->featured_photo->getClientOriginalName();
        };

        try {
            DB::transaction(function () use ($request, $fileName, $property, $newPhoto) {
                $property->update([
                    'location_id' => $request->location_id,
                    'property_type_id' => $request->type_id,
                    'name' => ucwords($request->name),
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'price' => $request->price,
                    'featured_photo' => $newPhoto ? $fileName : $property->featured_photo,
                    'purpose' => ucwords($request->purpose),
                    'bedroom' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    'garage' => $request->garage,
                    'size' => $request->size,
                    'floor' => $request->floor,
                    'balcony' => $request->balcony,
                    'address' => $request->address,
                    'built_year' => $request->year,
                    'map' => $request->map,
                ]);
                $property->amenities()->sync($request->amenities);
            });
            if ($newPhoto) {
                Storage::delete('property-images/' . $currentFeaturedPhoto);
                $request->featured_photo->storeAs('property-images', $fileName);
            };
            return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
        } catch (\Exception) {
            return back()->with('error', 'Failed to update property. Please try again.');
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return RedirectResponse
     */
    public function destroy(Property $property): RedirectResponse
    {
        $propertyPhotos = PropertyPhoto::where('property_id', $property->id)->get();
        foreach ($propertyPhotos as $photo) {
            Storage::delete('property-images/' . $photo->photo);
            $photo->delete();
        };
        $property->videos()->delete();
        $property->amenities()->detach();
        Storage::delete('property-images/' . $property->featured_photo);
        $property->delete();
        return back()->with('success', 'Property deleted successfully.');
    }

    /**
     * Activate a property listing by setting its status to active.
     *
     * This method updates the given property's `status` field to `1`, marking it as active.
     * It then redirects back to the previous page with a success message.
     *
     * @param Property $property
     * @return RedirectResponse
     */
    public function makeActive(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 1,
        ]);
        return back()->with('success', 'Property activated successfully.');
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param PropertyPhoto $propertyPhoto
     * @return RedirectResponse
     */
    public function destroyPhoto(PropertyPhoto $propertyPhoto): RedirectResponse
    {
        Storage::delete('property-images/' . $propertyPhoto->photo);
        $propertyPhoto->delete();
        return back()->with('success', 'Photo deleted successfully.');
    }

    /**
     * Remove the specified video from storage.
     *
     * @param PropertyVideo $propertyVideo
     * @return RedirectResponse
     */
    public function destroyVideo(PropertyVideo $propertyVideo): RedirectResponse
    {
        $propertyVideo->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}
