<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'activated_at',
    ];

    protected $casts = [
        'points' => 'integer',
        'activated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the UserActivity
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
