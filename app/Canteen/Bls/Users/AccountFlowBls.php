<?php

namespace App\Canteen\Bls\Users;

use App\Canteen\Bls\Users\Model\AccountFlowModel;
use Auth;

class AccountFlowBls
{

    public static function gitAccountFlowList($limit = 20)
    {
       return AccountFlowModel::where('user_id', Auth::guard('canteen')->id())->orderBy('id','desc')->simplePaginate($limit);
    }

    /**
     * 创建账户流水
     * @param $userId
     * @param $type
     * @param $amount
     * @param $describe
     * @return bool
     */
    public static function createAccountFlow($userId, $type, $amount, $describe)
    {
        $model = new AccountFlowModel();
        $model->user_id = $userId;
        $model->type = $type;
        $model->amount = $amount;
        $model->describe = $describe;
        return $model->save();
    }
}