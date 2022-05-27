<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'user_id', 'token'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('cart_qty');
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)->withPivot('cart_qty');
    }

    public function getTotalQty(): int
    {
        $qty = $this->loadSum('products', 'cart_product.cart_qty');

        return empty($this->products_sum_cart_productcart_qty) ? 0 : $this->products_sum_cart_productcart_qty;
    }

    public function getContent(): Collection
    {
        return $this->products;
    }

    public function getVouchers(): Collection
    {
        return $this->vouchers;
    }

    public function getTotal(bool $withDiscounts = true): float
    {
        $total = 0;

        foreach($this->products as $product) {
            $discount = 0;
            $productTotal = $product->getTotalPrice($product->pivot->cart_qty);

            if($withDiscounts == true && $this->vouchers) {
                $discount = 0;

                foreach($this->vouchers as $voucher) {
                    $discount += $voucher->getProductDiscount($productTotal, $product, $product->pivot->cart_qty);
                }
            }

            $total += ($productTotal - $discount);
        }

        $discountCart = 0;

        foreach($this->vouchers as $voucher) {
            $discountCart += $voucher->getCartDiscount($total);
        }

        return $total - $discountCart;
    }
}
