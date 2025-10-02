<?php

namespace App\Models;

use App\Models\Amenity;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\PropertyPhoto;
use App\Models\PropertyVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    use SoftDeletes;

    /**
     * All attributes are mass assignable.
     * Use with caution — this disables mass assignment protection.
     * Ensure sensitive fields are handled explicitly in controllers or services.
     */
    protected $guarded = [];

    /**
     * Get the property type associated with this property.
     *
     * Defines an inverse one-to-many relationship between this model and PropertyType.
     * Each property belongs to a single property type.
     *
     * @return BelongsTo
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the location associated with this property
     *
     * Defines an inverse one-to-many relationship between this model and Location.
     * Each property belongs to a single location.
     *
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the amenities associated with this property.
     *
     * Defines a many-to-many relationship between Property and Amenity.
     * Each property can have multiple amenities, and each amenity can belong to multiple properties.
     *
     * @return BelongsToMany
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the photos associated with this property.
     *
     * Defines a one-to-many relationship between Property and PropertyPhoto.
     * Each property can have multiple photos stored in the property_photos table.
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    /**
     * Get the videos associated with this property.
     *
     * Defines a one-to-many relationship between Property and PropertyVideo.
     * Each property can have multiple videos stored in the property_videos table.
     *
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class);
    }
}
