<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'category', 'location', 'year_founded', 'website',
        'contact_email', 'contact_phone', 'logo', 'cover_image', 'description',
        'target_audience', 'business_plan', 'sale_type', 'percentage_available',
        'price_per_share', 'total_shares', 'company_value', 'minimum_investment',
        'status', 'is_featured',
    ];

    protected $casts = [
        'percentage_available' => 'decimal:2',
        'price_per_share' => 'decimal:2',
        'company_value' => 'decimal:2',
        'minimum_investment' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function invitations()
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return str_starts_with($this->logo, 'http') ? $this->logo : \Illuminate\Support\Facades\Storage::url($this->logo);
        }
        return asset('images/default-logo.png');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return str_starts_with($this->cover_image, 'http') ? $this->cover_image : \Illuminate\Support\Facades\Storage::url($this->cover_image);
        }
        return asset('images/default-cover.jpg');
    }

    public function getFormattedValueAttribute(): string
    {
        return 'RD$' . number_format($this->company_value, 0, '.', ',');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'RD$' . number_format($this->price_per_share, 0, '.', ',');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
