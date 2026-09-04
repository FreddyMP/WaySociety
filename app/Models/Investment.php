<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id', 'company_id', 'percentage_acquired', 'amount_invested',
    ];

    protected $casts = [
        'percentage_acquired' => 'decimal:2',
        'amount_invested' => 'decimal:2',
    ];

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
