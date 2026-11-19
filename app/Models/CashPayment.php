<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashPayment extends Model
{
    protected $fillable = ['student_id', 'cash_week_id', 'paid_at', 'paid_by'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function cashWeek(): BelongsTo
    {
        return $this->belongsTo(CashWeek::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
