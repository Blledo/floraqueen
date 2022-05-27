<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\Voucher;

class CartRepository implements CartRepositoryInterface 
{
    public function create(array $details): Cart
    {
        return Cart::create($details); 
    }

    public function getById(int $id = null): Cart
    {
        return Cart::firstOrCreate(
            [
                'id' => $id
            ],
            [
                'id' => null,
                'user_id' => null,
                'token' => uniqid('', true)
            ]
        ); 
    }

    public function update(int $id, array $details): Cart
    {
        return Cart::where('id', $id)->update($details); 
    }

    public function delete(int $id)
    {
        Cart::destroy($id);
    }

    public function restore(int $id): Cart
    {
        return Cart::where('id', $id)->restore(); 
    }

    public function addProduct(int $id, int $productId, int $qty = 1): Cart
    {
        $cart = Cart::findOrFail($id);

        if(!$cart->products->contains($productId)) {
            $cart->products()->attach($productId, ['cart_qty' => $qty]);
        } else {
            $product = $cart->products->find($productId);
            $this->updateProduct($id, $productId, $qty + $product->pivot->cart_qty);
        }

        return $cart->refresh();
    }

    public function addVoucher(int $id, string $voucherCode, int $qty = 1): Cart
    {
        $cart = Cart::findOrFail($id); 
        $voucher = Voucher::where('code', $voucherCode)->firstOrFail(); 

        if(!$cart->vouchers->contains($voucher->id)) {
            $cart->vouchers()->attach($voucher->id, ['cart_qty' => $qty]);
        } else {
            $voucherPivot = $cart->vouchers->find($voucher->id);
            $this->updateVoucher($id, $voucherPivot->code, $qty + $voucherPivot->pivot->cart_qty);
        }

        return $cart->refresh();
    }

    public function updateProduct(int $id, int $productId, int $qty = 0): Cart
    {
        $cart = Cart::findOrFail($id); 

        if($qty <= 0) {
            $cart->products()->detach($productId);
        } else {
            $cart->products()->updateExistingPivot($productId, ['cart_qty' => $qty]);
        }

        return $cart->refresh();
    }

    public function updateVoucher(int $id, string $voucherCode, int $qty = 0): Cart
    {
        $cart = Cart::findOrFail($id);
        $voucher = Voucher::where('code', $voucherCode)->firstOrFail(); 

        if($qty <= 0) {
            $cart->vouchers()->detach($voucher->id);
        } else {
            $cart->vouchers()->updateExistingPivot($voucher->id, ['cart_qty' => $qty]);
        }
        
        return $cart->refresh();
    }

    public function removeProduct(int $id, int $productId): Cart
    {
        $cart = Cart::findOrFail($id);

        $cart->products()->detach($productId);

        return $cart->refresh();
    }

    public function removeVoucher(int $id, string $voucherCode): Cart
    {
        $cart = Cart::findOrFail($id);
        $voucher = Voucher::where('code', $voucherCode)->firstOrFail(); 

        $cart->vouchers()->detach($voucher->id);

        return $cart->refresh();
    }

    public function clear(int $id): Cart
    {
        $cart = Cart::findOrFail($id);
        
        $cart->products()->detach();
        $cart->vouchers()->detach();

        return $cart->refresh();
    }
}
