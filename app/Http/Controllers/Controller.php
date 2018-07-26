<?php

namespace App\Http\Controllers;

use App\Exceptions\LogicException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isEmpty($data)
    {
        if(! $data) {
            throw new LogicException(1010003, '数据查询失败');
        }
    }
}
