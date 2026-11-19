<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['nisn', 'name', 'gender', 'phone_number'];

    public function cashPayments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }

    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getTotalPaidAttribute(): int
    {
        return $this->cashPayments()->count() * 5000;
    }

    public function getTotalUnpaidAttribute(): int
    {
        $totalWeeks = CashWeek::count();
        $paidWeeks  = $this->cashPayments()->count();
        return ($totalWeeks - $paidWeeks) * 5000;
    }
}
