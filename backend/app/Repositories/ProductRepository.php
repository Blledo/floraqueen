<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface 
{
    public function getAll(): Collection
    {
        return Product::all(); 
    }

    public function create(array $details): Product
    {
        return Product::create($details); 
    }

    public function getById(int $id): Product
    {
        return Product::findOrFail($id); 
    }

    public function update(int $id, array $details): Product
    {
        Product::where('id', $id)->update($details);

        return Product::findOrFail($id); 
    }

    public function delete(int $id)
    {
        Product::destroy($id);
    }

    public function restore(int $id): Product
    {
        return Product::where('id', $id)->restore(); 
    }
}
