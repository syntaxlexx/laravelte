<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    // separation of concerns
    use UserAccessorsTrait;
    use UserRelationshipsTrait;
    use UserScopesTrait;


    /*
    |--------------------------------------------------------------------------
    | System Statuses
    |--------------------------------------------------------------------------
    |
    | provide a harmonized way of accessing system statuses
    |
    */
    CONST STATUS_ACTIVE = 'ACTIVE';
    CONST STATUS_BANNED = 'BANNED';
    CONST STATUS_FLAGGED = 'FLAGGED';
    CONST STATUS_UNDER_REVIEW = 'UNDER_REVIEW';
    CONST STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_BANNED,
        self::STATUS_FLAGGED,
        self::STATUS_UNDER_REVIEW,
    ];

    /*
    |--------------------------------------------------------------------------
    | System Roles
    |--------------------------------------------------------------------------
    |
    | provide a harmonized way of accessing system roles
    |
    */
    CONST ROLE_SUPERADMIN = 'SUPERADMIN';
    CONST ROLE_DEVELOPER = 'DEVELOPER';
    CONST ROLE_ADMIN = 'ADMIN';
    CONST ROLE_USER = 'USER';
    const ROLE_HUMANS = [
        self::ROLE_ADMIN,
        self::ROLE_USER,
    ];
    CONST ROLE_DEFAULT = self::ROLE_USER;
    CONST ROLES = [
        self::ROLE_SUPERADMIN,
        self::ROLE_DEVELOPER,
        self::ROLE_ADMIN,
        self::ROLE_USER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // username
        'email',
        'phone',
        'phone_verified_at',
        'status',
        'password',
        'first_name',
        'last_name',
        'last_login_at',
        'last_login_ip',
        'verified_at',
        'date_of_birth',
        'timezone',
        'role',
        'account_locked_till',
        'otp',
        'otp_expiry',
        'email_token',
        'enforce_password_reset',
        'application_domain',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'email_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'verified_at' => 'datetime',
        'date_of_birth' => 'datetime',
        'account_locked_till' => 'datetime',
        'otp_expiry' => 'datetime',
        'deleted_at' => 'datetime',
        'enforce_password_reset' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * toggle the enforce_password_reset attribute
     *
     * @param bool $enforce
     *
     * @return bool
     */
    public function enforcePasswordReset($enforce = true)
    {
        $this->attributes['enforce_password_reset'] = $enforce;
        return $this->save();
    }

    /**
     * Check if user has role
     */
    public function hasRole($roles)
    {
        if(! is_array($roles))
            $roles = [$roles];

        return in_array($this->role, $roles);
    }

    /**
     * check if a user can login into the system
     */
    public function canLogin() : bool
    {
        $canLogin = true;

        if(! in_array($this->status, [
            self::STATUS_ACTIVE,
            self::STATUS_FLAGGED,
            self::STATUS_UNDER_REVIEW,
        ])) {
            // only superadmins and developers can login - not even the admin
            if(! in_array($this->role, [self::ROLE_SUPERADMIN, self::ROLE_DEVELOPER])) {
                $canLogin = false;
            }
        }

        return $canLogin;
    }

}
