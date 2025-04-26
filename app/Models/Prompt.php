<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    protected $fillable = ['name', 'content'];
    protected $table = 'prompts';
}
