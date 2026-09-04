<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'age',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
