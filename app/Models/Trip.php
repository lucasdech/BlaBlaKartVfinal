<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'starting_point',
        'ending_point',
        'starting_at',
        'available_seats',
        'price',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starting_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the trip.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}