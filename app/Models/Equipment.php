<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Equipment extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_per_day',
        'is_price_negotiable',
        'status',
        'rented_until',
        'is_featured',
        'brand',
        'condition_notes',
        'sort_order',
    ];

    protected $casts = [
        'is_price_negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'rented_until' => 'date',
        'price_per_day' => 'decimal:2',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
            $price = number_format($this->price_per_day, 2, ',', ' ') . ' zł/dzień';
            if ($this->is_price_negotiable) {
                $price .= ' (do negocjacji)';
            }
            return $price;
        }
        return 'Cena do uzgodnienia';
    }
}
