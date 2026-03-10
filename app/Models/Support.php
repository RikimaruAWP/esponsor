<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'creator_id',
        'supporter_name',
        'message',
        'amount',
    ];

    public function creator()
    {
        return $this->belongsTo(Creator::class);
    }
}
