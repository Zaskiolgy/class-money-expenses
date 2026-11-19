<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'title', 'amount', 'expense_date', 'category',
        'note', 'receipt_image', 'recorded_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public static function categoryColors(): array
    {
        return [
            'ATK'       => 'blue',
            'Kebersihan'=> 'green',
            'Sosial'    => 'pink',
            'Acara'     => 'purple',
            'Lainnya'   => 'gray',
        ];
    }
}
