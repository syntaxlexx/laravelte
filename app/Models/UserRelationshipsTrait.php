<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserRelationshipsTrait
{
    public function logins(): HasMany
    {
        return $this->hasMany(UserLogin::class);
    }

    public function latestLogin(): HasOne
    {
        return $this->logins()->one()->latestOfMany();
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function loginTokens(): HasMany
    {
        return $this->hasMany(LoginToken::class);
    }
}
