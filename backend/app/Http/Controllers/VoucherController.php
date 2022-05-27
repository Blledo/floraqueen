<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\{
    JsonResponse,
    Request,
    Response
};

use App\Interfaces\VoucherRepositoryInterface;
use App\Interfaces\VoucherRuleRepositoryInterface;
use App\Models\Voucher;
use App\Models\VoucherRule;

use App\Http\Requests\VoucherRequest;
use App\Http\Requests\VoucherUpdateRequest;
use App\Http\Requests\VoucherRuleRequest;
use App\Http\Requests\VoucherRuleUpdateRequest;

class VoucherController extends Controller
{
    private VoucherRepositoryInterface $voucherRepository;
    private VoucherRuleRepositoryInterface $voucherRuleRepository;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository, 
        VoucherRuleRepositoryInterface $voucherRuleRepository
    ) {
        $this->voucherRepository = $voucherRepository;
        $this->voucherRuleRepository = $voucherRuleRepository;
    }

    public function getAll(Request $request): JsonResponse
    {
        try {
            $vouchers = $this->voucherRepository->getAll();
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(['data' => $vouchers], Response::HTTP_OK);
    }

    public function get(Request $request): JsonResponse
    {
        try {
            $voucher = $this->voucherRepository->getById($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($voucher);
    }

    public function create(VoucherRequest $request): JsonResponse
    {
        try {
            $voucher = $this->voucherRepository->create(
                $request->only([
                    'code',
                    'description',
                    'valid_from',
                    'valid_to',
                    'qty_available',
                    'max_applied'
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($voucher, Response::HTTP_CREATED);
    }

    public function update(VoucherUpdateRequest $request): JsonResponse
    {
        try {
            $voucher = $this->voucherRepository->update(
                $request->route('id'),
                $request->only([
                    'code',
                    'description',
                    'valid_from',
                    'valid_to',
                    'qty_available',
                    'max_applied'
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processData($voucher);
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->voucherRepository->delete($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getRules(Request $request): JsonResponse
    {
        try {
            $rules = $this->voucherRuleRepository->getAllByVoucher($request->route('id'));
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(['data' => $rules], Response::HTTP_OK);
    }

    public function getRule(Request $request): JsonResponse
    {
        try {
            $rule = $this->voucherRuleRepository->getById(
                $request->route('ruleId')
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processRule($rule);
    }

    public function createRule(VoucherRuleRequest $request): JsonResponse
    {
        try {
            $rule = $this->voucherRuleRepository->create(
                $request->route('id'),
                $request->only([
                    'reduction',
                    'reduction_type',
                    'reduction_model',
                    'model_id',
                    'min_qty',
                    'priority'
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processRule($rule);
    }

    public function updateRule(VoucherRuleUpdateRequest $request): JsonResponse
    {   
        try {
            $rule = $this->voucherRuleRepository->update(
                $request->route('ruleId'),
                $request->only([
                    'reduction',
                    'reduction_type',
                    'reduction_model',
                    'model_id',
                    'min_qty',
                    'priority'
                ])
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return $this->processRule($rule);
    }

    public function removeRule(Request $request): JsonResponse
    {   
        try {
            $this->voucherRuleRepository->delete(
                $request->route('ruleId')
            );
        } catch(Exception $e) {
            return $this->handleError($e->getMessage());
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function processData(Voucher $voucher, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Voucher info',
            'data' => $voucher
        ], $code);
    }

    private function processRule(VoucherRule $rule, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Voucher rule info',
            'data' => $rule
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
