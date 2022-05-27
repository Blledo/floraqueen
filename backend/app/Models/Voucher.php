<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\VoucherRule;
use App\Models\Product;

class Voucher extends Model
{
    use SoftDeletes;

    const REDUCTION_PERCENT_VALUE = 'percent';
    const REDUCTION_FIXED_VALUE = 'fixed';

    const REDUCTION_MODEL_PRODUCT = 'product';
    const REDUCTION_MODEL_PRODUCT_UNIT = 'product_unit';
    const REDUCTION_MODEL_CART = 'cart';

    protected $table = 'vouchers';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'code', 'description', 'valid_from', 'valid_to', 'qty_available', 'max_applied'];

    public function voucher_rules()
    {
        return $this->hasMany(VoucherRule::class);
    }

    public function getRules()
    {
        return $this->voucher_rules;
    }

    public function getProductDiscount(float $productTotal, Product $product, int $productQty): float
    {
        $discount = 0.0;

        foreach($this->voucher_rules as $rule) {
            switch($rule->reduction_model) {
                case 'product':
                    $discount += $this->checkProductDiscount($rule, $productTotal, $product, $productQty);
                    break;
                case 'product_unit':
                    $discount += $this->checkProductUnit($rule, $productTotal, $product, $productQty);
                    break;
                default:
                    break;
            } 
        }

        return $discount;
    }

    public function getCartDiscount(float $accumulated): float
    {
        $discount = 0.0;

        foreach($this->voucher_rules as $rule) {
            if($rule->reduction_model == self::REDUCTION_MODEL_CART) {
                $discount += $this->checkCartDiscount($rule, $accumulated);
            }
        }

        return $discount;
    }

    private function checkProductDiscount(VoucherRule $rule, float $productTotal, Product $product, int $productQty): float
    {
        $discount = 0.0;
        
        if($rule->model_id == $product->id) {
            $discountValue = $this->getReduction($rule->reduction, $product->price, $rule->reduction_type);

            if($productQty >= $rule->min_qty) {
                $discount = $discountValue * $productQty;
            }
        }

        return $discount;
    }

    private function checkProductUnit(VoucherRule $rule, float $productTotal, Product $product, int $productQty): float
    {
        $discount = 0.0;
        
        if($rule->model_id == $product->id) {
            $discountValue = $this->getReduction($rule->reduction, $product->price, $rule->reduction_type);
            $discount = $discountValue * floor(($productQty / $rule->min_qty));
        }

        return $discount;
    }

    private function checkCartDiscount(VoucherRule $rule, float $accumulated): float
    {
        $discount = 0.0;
        
        if($accumulated >= $rule->min_qty)  {
            $discount = $this->getReduction($rule->reduction, $accumulated, $rule->reduction_type);
        }

        return $discount;
    }

    private function getReduction(float $reduction, float $total, string $type): float
    {
        return $type == self::REDUCTION_PERCENT_VALUE ? 
            ($reduction / 100) * $total : 
            (($total - $reduction) < 0 ? $total : $reduction) 
        ;
    }

}
