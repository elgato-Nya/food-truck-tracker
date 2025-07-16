<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class FoodTruck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'food_type',
        'location_description',
        'latitude',
        'longitude',
        'menu_info',
        'news',
        'reported_by',
        'last_reported_at',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'last_reported_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Automatically set last_reported_at when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($foodTruck) {
            if (!$foodTruck->last_reported_at) {
                $foodTruck->last_reported_at = now();
            }
        });
    }

    // Scope for active trucks only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the location reports for this food truck
     */
    public function locationReports(): HasMany
    {
        return $this->hasMany(LocationReport::class);
    }

    /**
     * Get pending location reports for this food truck
     */
    public function pendingLocationReports(): HasMany
    {
        return $this->hasMany(LocationReport::class)->where('status', 'pending');
    }

    // Format for API response
    public function toApiArray()
    {
        $lastReportedAt = $this->last_reported_at ? Carbon::parse($this->last_reported_at) : null;
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'food_type' => $this->food_type,
            'location_description' => $this->location_description,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'menu_info' => $this->menu_info,
            'news' => $this->news,
            'reported_by' => $this->reported_by,
            'last_reported_at' => $lastReportedAt ? $lastReportedAt->format('c') : null,
            'last_reported_human' => $lastReportedAt ? $lastReportedAt->diffForHumans() : null,
        ];
    }
}
