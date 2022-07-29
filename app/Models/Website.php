<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] users
 */

class Website extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * one website can have many posts
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * The users that belong to the website.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
