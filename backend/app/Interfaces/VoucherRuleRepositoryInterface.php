<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\VoucherRule;

interface VoucherRuleRepositoryInterface 
{
    public function getAll(): Collection;
    public function getAllByVoucher(int $voucherId): Collection;
    public function getById(int $id): VoucherRule;
    public function create(int $voucherId, array $details): VoucherRule;
    public function update(int $id, array $details): VoucherRule;
    public function delete(int $id);
    public function restore(int $id): VoucherRule;
}
