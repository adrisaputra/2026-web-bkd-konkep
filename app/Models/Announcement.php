<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'text',
        'file',
        'count_view',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // # Relation
    public function announcement_viewer()
    {
        return $this->hasMany('App\Models\AnnouncementViewer');
    }
}
