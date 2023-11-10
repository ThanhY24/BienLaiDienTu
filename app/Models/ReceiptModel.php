<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_receipt';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pattern',
        'serial',
        'no',
        'fkey',
        'customer_name',
        'customer_id',
        'customer_tax_id',
        'customer_address',
        'publisher',
        'fee_name',
        'fee_cost',
        'quantity',
        'amount',
        'vat',
        'vat_amout',
        'total',
        'payment_method',
        'receipt_status',
        'publish_date',
        'type',
        'note',
        'log',
        'fee_id',
        'user_id',
    ];

    public function fee()
    {
        return $this->belongsTo(FeeModel::class, 'fee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
