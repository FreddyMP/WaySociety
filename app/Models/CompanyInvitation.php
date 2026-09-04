<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'investor_id', 'entrepreneur_id', 'message', 'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function entrepreneur()
    {
        return $this->belongsTo(User::class, 'entrepreneur_id');
    }
}
