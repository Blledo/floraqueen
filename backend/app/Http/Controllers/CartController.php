<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\{
    JsonResponse,
    Request,
    Response
};

use App\Interfaces\CartRepositoryInterface;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Validator;

use App\Models\Cart;

class CartController extends Controller
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository) 
    {
        $this->cartRepository = $cartRepository;
    }

    public function get(CartRequest $request, int $id): JsonResponse
    {
        try {
            $cart = $this->cartRepository->getById($id);
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }
        
        if(empty($cart)) {
            return $this->handleError('Invalid ID');
        }

        return $this->processData($cart);
    }

    public function create(): JsonResponse
    {
        try {
            $cart = $this->cartRepository->create(
                [
                    'user_id' => null,
                    'token' => uniqid('', true)
                ]
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart, Response::HTTP_CREATED);
    }

    public function clear(CartRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartRepository->clear($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    public function delete(CartRequest $request): JsonResponse
    {
        try {
            $this->cartRepository->delete($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function add(CartRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartRepository->addProduct(
                $request->route('id'), 
                $request->route('productId'),
                $request->input('qty', '1') 
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    public function update(CartRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartRepository->updateProduct(
                $request->route('id'), 
                $request->route('productId'),
                $request->input('qty', '0') 
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    public function remove(CartRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartRepository->removeProduct(
                $request->route('id'), 
                $request->route('productId')
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    public function addVoucher(CartRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartRepository->addVoucher(
                $request->route('id'), 
                $request->route('voucherCode'),
                1
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    public function removeVoucher(CartRequest $request): JsonResponse
    {   
        try {
            $cart = $this->cartRepository->removeVoucher(
                $request->route('id'), 
                $request->route('voucherCode')
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($cart);
    }

    private function processData(Cart $cart, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Cart info',
            'data' => [
                'id' => $cart->id,
                'total' => $cart->getTotal(),
                'total_qty' => $cart->getTotalQty(),
                'products' => $cart->getContent(),
                'vouchers' => $cart->getVouchers()
            ]    
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
