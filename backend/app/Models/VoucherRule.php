<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherRule extends Model
{
    use SoftDeletes;

    protected $table = 'voucher_rules';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'voucher_id', 'reduction', 'reduction_type', 'reduction_model', 'model_id', 'min_qty', 'priority'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
