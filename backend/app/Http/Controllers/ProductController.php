<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\{
    JsonResponse,
    Request,
    Response
};

use App\Interfaces\ProductRepositoryInterface;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) 
    {
        $this->productRepository = $productRepository;
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $products = $this->productRepository->getAll();
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    public function get(Request $request): JsonResponse
    {
        try {
            $product = $this->productRepository->getById($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($product);
    }

    public function create(ProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productRepository->create(
                $request->only([
                    'name',
                    'price',
                    'qty',
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request): JsonResponse
    {
        try {
            $product = $this->productRepository->update(
                $request->route('id'),
                $request->only([
                    'name',
                    'price',
                    'qty',
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($product);
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->productRepository->delete($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function processData(Product $product, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Product info',
            'data' => $product
        ], $code);
    }

    private function handleError(string $message, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => 'Error',
                'data' => [
                    'message' => $message
                ]
            ],
            $code
        );
    }
}
