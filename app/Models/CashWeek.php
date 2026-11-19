<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashWeek extends Model
{
    protected $fillable = ['label', 'week_number', 'month', 'year', 'amount', 'is_active'];

    public function cashPayments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }

    public function getPaidCountAttribute(): int
    {
        return $this->cashPayments()->count();
    }

    public function getTotalCollectedAttribute(): int
    {
        return $this->cashPayments()->count() * $this->amount;
    }
}
