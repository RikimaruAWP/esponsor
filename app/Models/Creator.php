<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'bio',
        'avatar_url',
    ];

    /**
     * Get the user that owns the creator profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the links for the creator profile.
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Get the supports (payments) for the creator.
     */
    public function supports()
    {
        return $this->hasMany(Support::class);
    }
}
