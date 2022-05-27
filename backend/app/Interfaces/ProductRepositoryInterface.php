<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Product;

interface ProductRepositoryInterface 
{
    public function getAll(): Collection;
    public function create(array $details): Product;
    public function getById(int $id): Product;
    public function update(int $id, array $details): Product;
    public function delete(int $id);
    public function restore(int $id): Product;
}
