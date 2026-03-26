<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Equipment extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_day',
        'price_3_days',
        'price_7_days',
        'price_14_days',
        'deposit',
        'is_price_negotiable',
        'status',
        'rented_until',
        'is_featured',
        'service_available',
        'brand',
        'condition_notes',
        'sort_order',
    ];

    protected $casts = [
        'is_price_negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'service_available' => 'boolean',
        'rented_until' => 'date',
        'price_per_day' => 'decimal:2',
        'price_3_days' => 'decimal:2',
        'price_7_days' => 'decimal:2',
        'price_14_days' => 'decimal:2',
        'deposit' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(ContactInquiry::class, 'equipment_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(300)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->nonQueued();
    }

    public function scopePublic($query)
    {
        return $query->whereIn('status', ['available', 'rented']);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', '!=', 'hidden');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Calculate price per day based on rental duration
     */
    public function calculatePrice(int $days): ?float
    {
        if ($this->is_price_negotiable && !$this->price_per_day) {
            return null;
        }

        // Select appropriate tier price
        if ($days >= 14 && $this->price_14_days) {
            return (float) $this->price_14_days;
        }
        if ($days >= 7 && $this->price_7_days) {
            return (float) $this->price_7_days;
        }
        if ($days >= 3 && $this->price_3_days) {
            return (float) $this->price_3_days;
        }

        return $this->price_per_day ? (float) $this->price_per_day : null;
    }

    /**
     * Calculate total price for rental period
     */
    public function calculateTotal(int $days): ?float
    {
        $pricePerDay = $this->calculatePrice($days);
        return $pricePerDay ? $pricePerDay * $days : null;
    }

    /**
     * Get pricing tiers for display
     */
    public function getPricingTiers(): array
    {
        $tiers = [];

        if ($this->price_per_day) {
            $tiers[] = [
                'days' => '1 dzień',
                'price_per_day' => $this->price_per_day,
                'formatted' => number_format($this->price_per_day, 2, ',', ' ') . ' zł/dzień',
            ];
        }

        if ($this->price_3_days) {
            $tiers[] = [
                'days' => '3-6 dni',
                'price_per_day' => $this->price_3_days,
                'formatted' => number_format($this->price_3_days, 2, ',', ' ') . ' zł/dzień',
            ];
        }

        if ($this->price_7_days) {
            $tiers[] = [
                'days' => '7-13 dni',
                'price_per_day' => $this->price_7_days,
                'formatted' => number_format($this->price_7_days, 2, ',', ' ') . ' zł/dzień',
            ];
        }

        if ($this->price_14_days) {
            $tiers[] = [
                'days' => '14+ dni',
                'price_per_day' => $this->price_14_days,
                'formatted' => number_format($this->price_14_days, 2, ',', ' ') . ' zł/dzień',
            ];
        }

        return $tiers;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Dostępny',
            'rented' => 'Wynajęty',
            'hidden' => 'Ukryty',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'available' => 'success',
            'rented' => 'warning',
            'hidden' => 'secondary',
            default => 'secondary',
        };
    }

    public function getPriceDisplayAttribute(): string
    {
        if ($this->is_price_negotiable && !$this->price_per_day) {
            return 'Cena do uzgodnienia';
        }

        if ($this->price_per_day) {
            // Find lowest price for "od X zł" display
            $lowestPrice = $this->price_per_day;
            if ($this->price_14_days && $this->price_14_days < $lowestPrice) {
                $lowestPrice = $this->price_14_days;
            } elseif ($this->price_7_days && $this->price_7_days < $lowestPrice) {
                $lowestPrice = $this->price_7_days;
            } elseif ($this->price_3_days && $this->price_3_days < $lowestPrice) {
                $lowestPrice = $this->price_3_days;
            }

            $hasMultipleTiers = $this->price_3_days || $this->price_7_days || $this->price_14_days;
            $prefix = $hasMultipleTiers ? 'od ' : '';
            $price = $prefix . number_format($lowestPrice, 2, ',', ' ') . ' zł/dzień';

            if ($this->is_price_negotiable) {
                $price .= ' (do negocjacji)';
            }
            return $price;
        }

        return 'Cena do uzgodnienia';
    }

    public function getDepositDisplayAttribute(): string
    {
        if ($this->deposit) {
            return number_format($this->deposit, 2, ',', ' ') . ' zł';
        }
        return 'Brak';
    }
}
