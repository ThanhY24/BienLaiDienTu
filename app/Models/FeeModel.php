<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_fee';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fee_id',
        'fee_unit',
        'fee_name',
        'fee_cost',
        'fee_des',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
