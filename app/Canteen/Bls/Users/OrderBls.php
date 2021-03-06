<?php

namespace App\Canteen\Bls\Users;

use App\Admin\Bls\Other\FeedbackBls;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Canteen\Bls\Canteen\TakeoutBls;
use App\Canteen\Bls\Users\Model\OrderMealModel;
use App\Canteen\Bls\Users\Model\OrderModel;
use App\Canteen\Bls\Users\Model\OrderTakeoutModel;
use App\Consts\Common\AccountFlowTypeConst;
use App\Consts\Common\MealTypeConst;
use App\Consts\Order\OrderStatusConst;
use App\Consts\Order\OrderTypeConst;
use Auth;

/**
 * Created by OrderBls.
 * @author: zouxiang
 * @date:
 */
class OrderBls
{


    /**
     * @param $request
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public static function getOrderList($request, $limit = 20)
    {
        $model = OrderModel::query();

        if(!empty($request->status)) {
            $status = explode('_', $request->status);
            $model->whereIn('status', $status);
        }

        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        if(!empty($request->status)) {
            $model->where('status', $request->status);
        }

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        if(!empty($request->user_id)) {
            $model->where('user_id', $request->user_id);
        }

        return $model->orderBy('id','desc')->simplePaginate($limit);
    }

    /**
     * 外卖订单创建
     * @param $data
     * @param $amount
     * @param $deposit
     * @return mixed
     */
    public static function createTakeoutOrder($data, $amount, $deposit)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($data, $amount, $deposit) {
            $user = Auth::guard('canteen')->user();
            $user->money -= $deposit;

            $order = new OrderModel();
            $order->user_id = $user->id;
            $order->amount = $amount;
            $order->deposit = $deposit;
            $order->status = OrderStatusConst::DEPOSIT;
            $order->type = OrderTypeConst::TAKEOUT;
            $order->payment = $deposit;
            $order->save();

            foreach($data as $item){
                static::createTakeoutOrderByChild($item, $order->id);
            }

            AccountFlowBls::createAccountFlow($user->id, AccountFlowTypeConst::PAYMENT, $deposit, "订单号:{$order->id}外卖定金", MealTypeConst::TAKEOUT);

            return $user->save();
        });
    }

    /**
     *
     * 外卖订单关联创建
     * @param $data
     * @param $orderID
     * @return bool
     */
    private static function createTakeoutOrderByChild($data, $orderID)
    {

        $model = new OrderTakeoutModel();
        $model->order_id = $orderID;
        $model->takeout_id = $data['id'];
        $model->name = $data['title'];
        $model->price = $data['price'];
        $model->deposit = $data['deposit'];
        $model->num = $data['num'];
        $model->is_weigh = $data['is_weigh'];

        $takeout = TakeoutBls::find($data['id']);
        $takeout->stock -= $data['num'];
        $takeout->save();

        return $model->save();
    }


    /**
     * 点餐订购
     * @param $data
     * @param $amount
     * @param $deposit
     * @return mixed
     */
    public static function createMealOrder($data, $amount, $deposit)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($data, $amount, $deposit) {
            $user = Auth::guard('canteen')->user();
            $user->money -= $deposit;
            $order = new OrderModel();
            $order->user_id = $user->id;
            $order->amount = $amount;
            $order->deposit = $deposit;
            $order->status = OrderStatusConst::DEPOSIT;
            $order->type = OrderTypeConst::MEAL;
            $order->payment = $deposit;
            $order->save();

            static::createMealOrderByChild($data, $order->id);

            $name = "订单号:{$order->id}订购{$data['date']}" . MealTypeConst::getDesc($data['type']) . '定金';
            AccountFlowBls::createAccountFlow($user->id, AccountFlowTypeConst::PAYMENT, $deposit, $name, $data['type']);

            return $user->save();
        });
    }

    /**
     * 点餐管理数据
     * @param $data
     * @param $orderId
     * @return bool
     */
    public static function createMealOrderByChild($data, $orderId)
    {
        $model = new OrderMealModel();
        $model->order_id = $orderId;
        $model->recipes_id = $data['recipes_id'];
        $model->type = $data['type'];
        $model->date = $data['date'];
        $model->num = $data['num'];
        $model->price = $data['price'];
        $model->discount = intval($data['discount']);
        return $model->save();
    }

    /**
     *  统计本周点餐过期量
     * @param $userId
     * @return int
     */
    public static function countOverdueByMeal($userId)
    {
        $date = new \DateTime();
        $date->modify('this week');
        $firstDayWeek = $date->format('Y-m-d');
        $date->modify('this week +6 days');
        $endDayWeek = $date->format('Y-m-d');

        $model = OrderModel::query();
        $model->leftJoin('order_meal as meal', 'order.id', '=', 'meal.order_id');
        $model->where('order.user_id', $userId);
        $model->where('order.type', OrderTypeConst::MEAL);
        $model->where('order.status', OrderStatusConst::OVERDUE);
        $model->where('meal.date', '>=', $firstDayWeek);
        $model->where('meal.date', '<=', $endDayWeek);
        return $model->count();
    }

    /**
     * 统计本月外卖退单数量
     * @param $userId
     * @return int
     */
    public static function countOverdueByTakeout($userId)
    {
        $date = new \DateTime();
        $date->modify('first day of this month');
        $firstMonthWeek = $date->format('Y-m-d 00:00:00');

        $date->modify('this month +1 month -1 day');
        $endMonthWeek = $date->format('Y-m-d 23:59:59');

        $model = OrderModel::query();
        $model->where('user_id', $userId);
        $model->where('type', OrderTypeConst::TAKEOUT);
        $model->where('status', OrderStatusConst::REFUND);
        $model->where('created_at', '>=', $firstMonthWeek);
        $model->where('created_at', '<=', $endMonthWeek);
        return $model->count();
    }

    public static function find($id)
    {
        return OrderModel::find($id);
    }

    /**
     * 外卖退单
     * @param OrderModel $model
     * @return mixed
     */
    public static function refund(OrderModel $model)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($model) {
            $user = Auth::guard('canteen')->user();
            $user->money += $model->deposit;

            $model->orderTakeout->each(function($item) {
                $takeout = TakeoutBls::find($item->takeout_id);
                if($takeout) {
                    $takeout->stock += $item->num;
                    $takeout->save();
                }
            });
            $model->status = OrderStatusConst::REFUND;
            $model->save();

            $name = "订单号:{$model->id}外卖退单";
            AccountFlowBls::createAccountFlow($user->id, AccountFlowTypeConst::REFUND, $model->deposit, $name, MealTypeConst::TAKEOUT);

            return $user->save();
        });

    }

    /**
     * 支付定金的就餐订单
     * @param $time
     * @param $type
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getOrderByMeal($time, $type, $userId)
    {
        $model = OrderModel::query();
        $model->where('user_id', $userId);
        $model->where('type', OrderTypeConst::MEAL);
        $model->where('status', OrderStatusConst::DEPOSIT);
        $model->with(['orderMeal']);
        $model->whereHas('orderMeal', function ($query)  use($time, $type) {
            $time = mb_substr($time,0,10);
            $query->where('type', $type)->where('date', $time);
        });

        return $model->first();
    }

    /**
     * 获取外面订单
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getOrderTakeout($userId)
    {
        $model = OrderModel::query();
        $model->where('user_id', $userId);
        $model->where('type', OrderTypeConst::TAKEOUT);
        $model->where('status', OrderStatusConst::DEPOSIT);
        $model->with(['orderTakeout']);
        return $model->first();
    }

    /**
     * 订单支付
     * @param $order
     * @param $users
     * @return mixed
     */
    public static function payment($order, $users)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($order, $users) {

            $amount = $users->getOriginal('money') - $users->money;

            $order->payment_at = date('Y-m-d H:i:s');
            $order->payment += $amount;
            $order->status = OrderStatusConst::PAYMENT;
            $order->save();


            if($order->type == OrderTypeConst::TAKEOUT) {
                $typeName = OrderTypeConst::getDesc($order->type);
                $name = "订单号:{$order->id}{$typeName}支付尾款";
                $useType = MealTypeConst::TAKEOUT;
            } else {
                $meal = $order->orderMeal;
                $typeName = MealTypeConst::getDesc($meal->type);
                $name = "订单号:{$order->id} ($meal->date{$typeName})支付尾款";
                $useType = $meal->type;
            }

            AccountFlowBls::createAccountFlow($users->id, AccountFlowTypeConst::PAYMENT, $amount, $name, $useType);

            return $users->save();
        });
    }

    /**
     * 评论
     * @param $model
     * @param FeedbackRequests $request
     * @return mixed
     */
    public static function comment($model, FeedbackRequests $request)
    {
        return OrderModel::query()->getQuery()->getConnection()->transaction(function () use($model, $request) {


            FeedbackBls::storeFeedback($request);
            $model->status = OrderStatusConst::FINISH;
            return $model->save();
        });
    }
}
