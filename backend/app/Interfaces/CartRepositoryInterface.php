<?php

namespace App\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface 
{
    public function create(array $details): Cart;
    public function getById(int $id): Cart;
    public function update(int $id, array $details): Cart;
    public function delete(int $id);
    public function restore(int $id): Cart;
    public function addProduct(int $id, int $productId, int $qty = 1): Cart;
    public function addVoucher(int $id, string $voucherCode, int $qty = 1): Cart;
    public function updateProduct(int $id, int $productId, int $qty = 0): Cart;
    public function updateVoucher(int $id, string $voucherCode, int $qty = 0): Cart;
    public function removeProduct(int $id, int $productId): Cart;
    public function removeVoucher(int $id, string $voucherCode): Cart;
    public function clear(int $id): Cart;
}
