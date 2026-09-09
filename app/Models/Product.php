<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'description', 'target_audience', 'image',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return str_starts_with($this->image, 'http') ? $this->image : \Illuminate\Support\Facades\Storage::url($this->image);
        }
        return asset('images/default-product.png');
    }
}
