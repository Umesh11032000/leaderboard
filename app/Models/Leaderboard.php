<?php

namespace App\Models;

use App\Enums\Period;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    protected $table = 'leaderboards';

    protected $fillable = [
        'user_id',
        'points',
        'rank',
        'period',
    ];

    protected $casts = [
        'points' => 'integer',
        'rank' => 'integer',
        'period' => Period::class,
    ];

    /**
     * Get the user that owns the Leaderboard
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include for a given period
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Enums\Period  $period
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPeriod($query, Period $period): Builder
    {
        return $query->where('period', $period->value);
    }
}
