<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name', 'email', 'phone',
        'subject',
        'body',
        'site_domain',
        'ip_address',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    /**
     * belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
