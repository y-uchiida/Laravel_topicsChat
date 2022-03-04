<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillabele = [
        'name',
        'user_id',
        'is_user_checked',
        'latest_comment_time'
    ];
}
