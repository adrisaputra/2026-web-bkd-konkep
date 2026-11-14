<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementViewer extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'ip_address',
    ];

    public function announcement()
    {
        return $this->belongsTo('App\Models\News');
    }
}
