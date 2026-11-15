<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transparency extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'category',
        'title',
        'slug',
        'text',
        'file',
        'count_view',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
