<?php

namespace App\Models;

trait UserScopesTrait
{
    /*
     * Fetch all the users with no sudo role
     */
    public function scopeHumans($query)
    {
        return $query->where('role', '<>', [User::ROLE_ADMIN, User::ROLE_SUPERADMIN, User::ROLE_DEVELOPER]);
    }

    /*
     * Fetch all the users with no sudo role
     */
    public function scopeNonAdmins($query)
    {
        return $this->scopeHumans($query);
    }

    /*
     * Fetch all the users with admin role
     */
    public function scopeAdmins($query)
    {
        if(setting('add_sudo_to_admin_group')) {
            return $query->whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPERADMIN, User::ROLE_DEVELOPER]);
        }

        return $query->where('role', User::ROLE_ADMIN);
    }
}
