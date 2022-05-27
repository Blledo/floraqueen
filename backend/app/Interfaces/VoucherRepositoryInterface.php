<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Voucher;

interface VoucherRepositoryInterface 
{
    public function getAll(): Collection;
    public function create(array $details): Voucher;
    public function getById(int $id): Voucher;
    public function update(int $id, array $details): Voucher;
    public function delete(int $id);
    public function restore(int $id): Voucher;
}