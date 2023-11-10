<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_notification';

    protected $fillable = ['notification_title', 'notification_content', 'user_to', 'user_from'];

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_to');
    }

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from');
    }
}
