<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
