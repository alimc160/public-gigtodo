<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Notifications\BuyerOrderCompleteNotification;

class OrderService
{
    /**
     * @var Order
     */
    private $order;

    public function __construct()
    {
        $this->order = new Order;
        $this->user = new User;
    }

    /**
     * @param $perPage
     * @param $request
     * @param false $paginate
     * @return array
     */
    public function getAllSellerOrders($perPage, $request, $user, $paginate = false)
    {
        $order = $this->order->where('seller_id', $user->id);
        $total = 0;
        if ($paginate == false) {
            $orders = $order->orderBy('id', 'desc')->get();
            $total = $order->count();
        } else {
            $orders = $order->orderBy('id', 'desc');
            $total = $order->get()->count();
            $orders = $order->paginate($perPage);
        }
        return ['result' => $orders, 'total' => $total];
    }

    /**
     * @param $id
     * @param $user
     * @return mixed
     */
    public function getSellerOrder($id, $user)
    {
        return $this->order->where('seller_id', $user->id)->find($id);
    }

    /**
     * @param $id
     * @param $request
     * @param $user
     * @return string[]
     */
    public function changeOrderStatus($id, $request, $user)
    {
        $order = $this->order->where('seller_id', $user->id)->find($id);
        $order->status = $request['status'];
        $order->save();
        return ['message' => 'Order status has been changed successfully!'];
    }

    public function paymentDetails($user){
        $order = $this->order->getSellerOrder($user);
        $totalOrders = $order->count();
        $totalPendingOrders = $order->orderStatus('pending')->count();
        $totalCompletedOrders = $order->orderStatus('completed')->count();
        $totalBalance = $order->orderStatus('completed')->sum('sub_total');
        $totalPayout = $order->orderApproved()->sum('sub_total');
        return [
            'total_orders' => $totalOrders,
            'total_pending_orders' => $totalPendingOrders,
            'total_completed_orders' => $totalCompletedOrders,
            'total_balance' => $totalBalance,
            'total_payout' => $totalPayout
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function changeStatusOrderComplete($id){
        $order=$this->order->find($id);
        $buyerId=$order->buyer_id;
        $user=$this->user->find($buyerId);
        $order->status = "completed";
        $order->save();
        $user->notify(new BuyerOrderCompleteNotification($order));
        return['result'=>$order,'total'=>1];
    }
}
