<?php

namespace App\Repositories;

use App\Interfaces\VoucherRuleRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Voucher;
use App\Models\VoucherRule;

class VoucherRuleRepository implements VoucherRuleRepositoryInterface 
{
    public function getAll(): Collection
    {
        return VoucherRule::all(); 
    }

    public function getAllByVoucher(int $voucherId): Collection
    {
        return VoucherRule::where('voucher_id', $voucherId)->get(); 
    }

    public function create(int $voucherId, array $details): VoucherRule
    {
        $voucher = Voucher::findOrFail($voucherId); 

        return $voucher->voucher_rules()->create($details); 
    }

    public function getById(int $id): VoucherRule
    {
        return VoucherRule::findOrFail($id); 
    }

    public function update(int $id, array $details): VoucherRule
    {
        VoucherRule::where('id', $id)->update($details);

        return VoucherRule::findOrFail($id);
    }

    public function delete(int $id)
    {
        VoucherRule::destroy($id);
    }

    public function restore(int $id): VoucherRule
    {
        return VoucherRule::where('id', $id)->restore(); 
    }
}
