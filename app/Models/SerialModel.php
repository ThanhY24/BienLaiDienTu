<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_serial';
    protected $fillable = ['serial', 'pattern_id', 'user_id'];
    public function pattern()
    {
        return $this->belongsTo(Pattern::class, 'pattern_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
