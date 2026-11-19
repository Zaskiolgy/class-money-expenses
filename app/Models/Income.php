<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = [
        'title', 'amount', 'income_date', 'category', 'note', 'recorded_by',
    ];

    protected $casts = [
        'income_date' => 'date',
    ];

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public static function categoryColors(): array
    {
        return [
            'Iuran'     => 'indigo',
            'Sumbangan' => 'teal',
            'Lainnya'   => 'gray',
        ];
    }
}
