<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id',
        'title',
        'url',
    ];

    public function creator()
    {
        return $this->belongsTo(Creator::class);
    }
}
