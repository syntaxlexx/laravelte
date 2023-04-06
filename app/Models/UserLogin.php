<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLogin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'ip_address',
        'notes',
        'browser_info',
        'operating_system',
        'device_info',
    ];

    /**
     * the user
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * get logins without user; either due to deletion or something
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrphans($query)
    {
        return $query->whereDoesntHave('user');
    }

    /**
     * get logins only for humans
     */
    public function scopeHumans($query)
    {
        return $query->whereHas('user', function($q) {
            $q->humans();
        });
    }
}
