<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Message;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'is_user_checked',
        'latest_comment_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
