<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'consumed_at',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isValid() : bool
    {
        return !$this->isExpired() && !$this->isConsumed();
    }

    public function isExpired() : bool
    {
        return $this->expires_at->isBefore(now());
    }

    public function isConsumed() : bool
    {
        return $this->consumed_at !== null;
    }

    public function consume() : void
    {
        $this->consumed_at = now();
        $this->save();
    }
}
