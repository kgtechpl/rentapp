<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInquiry extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'equipment_id',
        'message',
        'rental_date_from',
        'rental_date_to',
        'status',
        'ip_address',
        'created_at',
    ];

    protected $casts = [
        'rental_date_from' => 'date',
        'rental_date_to' => 'date',
        'created_at' => 'datetime',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new' => 'Nowe',
            'read' => 'Przeczytane',
            'replied' => 'Odpowiedziano',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'new' => 'danger',
            'read' => 'warning',
            'replied' => 'success',
            default => 'secondary',
        };
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
