<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatternModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_pattern';
    protected $fillable = ['pattern', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
