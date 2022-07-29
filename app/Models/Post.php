<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string title
 * @property string body
 * @property-read Website $website
 */
class Post extends Model
{
    use HasFactory;

    protected  $guarded = ['id'];

    public function website(): HasOne
    {
        return $this->hasOne(Website::class);
    }
}
