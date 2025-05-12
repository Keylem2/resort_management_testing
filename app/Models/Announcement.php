<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content'];

    // Relationships (if needed in the future)
    // public function staffHead()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
