<?php

namespace App\Repositories;

use App\Interfaces\VoucherRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Voucher;

class VoucherRepository implements VoucherRepositoryInterface 
{
    public function getAll(): Collection
    {
        return Voucher::with('voucher_rules')->get(); 
    }

    public function create(array $details): Voucher
    {
        return Voucher::create($details); 
    }

    public function getById(int $id): Voucher
    {
        return Voucher::where('id', $id)->with('voucher_rules')->firstOrFail(); 
    }

    public function update(int $id, array $details): Voucher
    {
        $voucher = Voucher::where('id', $id)->with('voucher_rules')->firstOrFail();

        $voucher->update($details);

        return $voucher->refresh();
    }

    public function delete(int $id)
    {
        Voucher::destroy($id);
    }

    public function restore(int $id): Voucher
    {
        return Voucher::where('id', $id)->restore(); 
    }
}
