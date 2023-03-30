<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait UserAccessorsTrait
{
    /**
     * Interact with the user's role.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }

    /**
     * Interact with the user's name (username).
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtolower($value),
        );
    }

    /**
     * Interact with the user's email.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtolower($value),
        );
    }

    /**
     * An alias to get the username (name)
     */
    public function username(): Attribute
    {
        return Attribute::make(
            get: fn ($val, $attr) => $this->name,
        );
    }

    public function isSudo(): Attribute
    {
        return Attribute::make(
            get: fn ($val, $attr) => in_array($this->role, [User::ROLE_SUPERADMIN, User::ROLE_DEVELOPER]),
        )->shouldCache();
    }

    public function isAdmin(): Attribute
    {
        $shouldAddSudo = setting('add_sudo_to_admin_group');

        return Attribute::make(
            get: fn ($val, $attr) => $shouldAddSudo ? in_array($this->role, [User::ROLE_SUPERADMIN, User::ROLE_DEVELOPER, User::ROLE_ADMIN]) : $this->role === User::ROLE_ADMIN,
        )->shouldCache();
    }

    public function isActive()
    {
        return $this->status === User::STATUS_ACTIVE;
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($val, $attr) => $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name,
        );
    }

    /**
     * check if account is locked
     */
    public function isLocked(): Attribute
    {
        return Attribute::make(
            get: fn ($val, $attr) => !!$this->account_locked_till,
        );
    }

    /**
     * check if account is locked
     */
    public function avatarUrl(): Attribute
    {
        $backgroundColor = '0D8ABC';
        $color = 'fff';
        $avatars = ['avatar.png', 'avatar.jpg', 'placeholder.png', 'placeholder.jpg'];

        return Attribute::make(
            get: fn ($val, $attr) => $this->profile_photo_url && !in_array($this->profile_photo_url, $avatars) ? route('user.avatar', $this->profile_photo_url)
                : "https://ui-avatars.com/api/?background=" . $backgroundColor . "&color=" . $color . "&name=" . $this->name ?? 'A',
        )->shouldCache();
    }

    /**
     * check if has verified phone
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return !!$this->phone_verified_at;
    }
}
