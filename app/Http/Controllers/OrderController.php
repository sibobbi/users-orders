<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Resources\Order\IndexResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Payment;
use App\Service\BasketService;
use App\Service\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(Order $order): IndexResource
    {
        return IndexResource::make($order);
    }
    public function index(IndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $sort = $request->validated('sort') ?? false;
        $filter = OrderStatus::tryFrom($request->validated('filter'));
        $orderQuery = $request->user()->orders()->query();

        if ($sort) {
            $orderQuery->orderBy('created_at', $sort);
        }
        if ($filter) {
            $orderQuery->where('status', $filter);
        }

        return IndexResource::collection($orderQuery->get());
    }

    public function create(CreateRequest $request, OrderService $service, BasketService $basketService)
    {
        $basket = Basket::query()->find($request->validated('basket_id'));
        $paymentType = Payment::query()->find($request->validated('payment_type'));

        try {
            DB::beginTransaction();
            $order = $service->create($basket, $paymentType);
            $basketService->clear($basket);
            DB::commit();

            return OrderResource::make($order);
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function update(Order $order)
    {
        $order->update(['status' => OrderStatus::PAID]);

        return response()->status(202);
    }
}
