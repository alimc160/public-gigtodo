<?php

namespace App\Http\Controllers\Api\Seller;

use App\Exports\OrderDetailsExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\BuyerOrderCompleteNotification;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->orderService = new OrderService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders(Request $request)
    {
        try {
            $response = $this->orderService->getAllSellerOrders(10, $request->all(), auth()->user());
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'total_orders' => $response['total'],
                'data' => $response['result']
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getMessage(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrder($id, Request $request)
    {
        try {
            $response = $this->orderService->getSellerOrder($id, $request->user());
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => $response
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getMessage(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveOrRejectOrder($id, Request $request)
    {
        $request->validate([
            'status' => 'required'
        ]);
        try {
            $response = $this->orderService->changeOrderStatus($id, $request->all(), $request->user());
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'message' => $response['message']
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getMessage(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function getPaymentDetails(Request $request)
    {
        try {
            $response = $this->orderService->paymentDetails($request->user());
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => [
                    'total_balance' => $response['total_balance'],
                    'total_payout' => $response['total_payout'],
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getMessage(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function orderComplete($id)
    {
        try {
            $response = $this->orderService->changeStatusOrderComplete($id);
            return response()->json([
                'status' => 'success',
                'status_code' => 200,
                'data' => $response['result']
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'status_code' => $exception->getMessage(),
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadOrderExcelSheet($id){
        $order = Order::find($id);
        return \Maatwebsite\Excel\Facades\Excel::download(new OrderDetailsExport($order), 'order.xlsx');
    }
}
