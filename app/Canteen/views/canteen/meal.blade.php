@extends('canteen::layouts.master')

@section('style')
    <style>

    </style>
@stop

@section('content')

    <div id="page-comesoon" class="page">
        <header class="bar bar-nav">
            <a class="footer-nav-back " href="{!! route('c.member') !!}"></a>

            <h1 class="page-title">{!! $date !!}菜单</h1>
        </header>

        <div class="bar footer-nav">
            <a class="footer-nav-back" href="{!! route('c.member') !!}"></a>

            <div style="float: left">
                <p style="padding-left: 2rem;color: red">￥ <span class="amount">0.00</span> </p>
            </div>

            <div style="float: right">
                <button class="external takeout-buy">订购<span class="meal-type-name">早餐</span>
                </button>
            </div>

        </div>
        <div class="content native-scroll takeout">

            <div class="content-block">
                <p class="buttons-row"> 预定截止时间
                <span style="color: red" class="deadline">
                    {!! config('config.meal_deadline') !!} : 00
                </span>
                    点</p>
                {{--<p class="buttons-row"> 每周违约 <span style="color: red"> {!! config('config.meal_overdue_num') !!} </span>--}}
                    {{--次将不能预约, <span style="padding-left: 5px">你已违约{!! $overdue !!}次</span></p>--}}
                <p class="buttons-row">
                    @foreach($menu as $key => $value)
                        <a href="{!! route('c.canteen.meal', ['date' => $value]) !!}" class="button external button-round {!! $value == $date ? 'active' : ''!!}">
                            {!! $key !!}
                        </a>
                    @endforeach
                </p>
                <div class="buttons-row menu">
                    <a href="#tab1" data-type="{!! \App\Consts\Common\MealTypeConst::MORNING !!}" class="tab-link active button">早餐</a>
                    <a href="#tab2" data-type="{!! \App\Consts\Common\MealTypeConst::LUNCH !!}" class="tab-link button">中餐</a>
                    <a href="#tab3" data-type="{!! \App\Consts\Common\MealTypeConst::DINNER !!}"  class="tab-link button">晚餐</a>
                </div>
            </div>
            <div class="tabs">
                <div id="tab1" class="tab active">
                    <div class="content-block">
                       {!! $info ? str_replace("\r\n", '<br>', $info->morning) : '没有设置早餐' !!}
                    </div>
                </div>
                <div id="tab2" class="tab">
                    <div class="content-block">
                        {!! $info ? str_replace("\r\n", '<br>', $info->lunch) : '没有设置午餐' !!}
                    </div>
                </div>
                <div id="tab3" class="tab">
                    <div class="content-block">
                        {!! $info ? str_replace("\r\n", '<br>', $info->dinner) : '没有设置晚餐' !!}
                    </div>
                </div>
            </div>
        </div>
        <input name="data" type="hidden" value='{!! $data !!}'>
    </div>
    <div class="popup takeout-buy-services">
        <div class="content-block">
            <header class="bar bar-nav">
                <a class="footer-nav-back close-popup" href="javascript:;"></a>
                <h1 class="page-title">我的购物车</h1>
            </header>
            <p><a href="#" class="close-popup">Close popup</a></p>
            <div class="content">
                <div class="list-block">
                    <ul class="takeout-buy-content">
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title meal-name">早餐</div>
                                <div class="item-title"><span class="meal-price" style="color: red"></span>元</div>
                                <div class="item-after meal-click item-subtitle">
                                    <span class="minus"><i class="fa fa-minus-circle"></i></span>
                                    <span class="num">1</span>
                                    <span class="plus"><i class="fa fa-plus-circle"></i></span>
                                </div>

                                </div>
                            </li>
                    </ul>
                </div>

                <div class="content-block">

                </div>
                <div id="tab1" class="tab active">
                    <div class="item-inner b1" style="">
                        <p>大于两份将从第二份开始双倍价格</p>
                        <p>价格：<span  style="color: red" class="amount">0.00</span>元</p>
                        <p>折扣：<span  style="color: red" class="meal-discount"></span>折</p>
                        <p>定金：<span  style="color: red" class="buy-deposit">1.00</span>元</p>
                    </div>
                </div>
            </div>

            <div class="bar footer-nav">

                <a class="footer-nav-back close-popup" href="javascript:;"></a>

                <div style="float: right"><button class="external takeout-buy-submit" >支付</button></div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            var meal = JSON.parse($('input[name=data]').val());
            meal.deposit = parseInt(meal.deposit);

            var data = {
                "type" : 0,
                "num" : 1,
                "amount" : 0,
                "deposit" : 0,
                "price" : 0,
                "discount" : 0,
                "date" : '{!! $date !!}',
                "recipes_id" : '{!! $info ? $info->id : '' !!}',
                "_method":"PUT",
                "_token":$('meta[name="csrf-token"]').attr('content')
            };
            var price = 0;
            var locked = true;
            var check = false;
            var info = '{!! $info ? 0 : 1 !!}';

            $('.menu a').click(function() {

                data.type = $(this).attr('data-type');
                data.price = parseInt(meal.price[data.type]);

                data.deposit = parseInt(meal.deposit * data.num);

                $('.meal-type-name').text(meal.type[data.type]);
                $('.amount').text(fmoney(data.price / 100));
                $('.buy-deposit').text(fmoney(data.deposit / 100));
                $('.deadline').text(meal.time[data.type]);
                check = meal.currentTime > meal.endTime[data.type] || info == 1;

                $('.takeout-buy').attr("style", "");
                if(check) {
                    $('.takeout-buy').css({ "background-color":"#848484"})
                }
                var hour = (meal.endTime[data.type] - meal.currentTime)/60/60;
                hour = hour.toFixed(2);

                if(hour < 24) {
                    data.discount = parseInt(meal.discount[1]) / 100;
                } else {
                    data.discount = parseInt(meal.discount[2]) / 100;
                }

                $('.meal-discount').text(data.discount * 100);
            });

            $('.menu a').eq(0).trigger('click');

            //我的购物车
            $('.takeout-buy').click(function() {

                if(info == 1) {
                    $.alert('没有可预订的就餐');
                    return false;
                }

                if(check) {
                    $.alert('订购时间已截止');
                    return false;
                }

                $('.meal-name').text(meal.type[data.type]);

                data.amount = (((data.num - 1) * (data.price * 2)) + data.price) * data.discount;
                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);

                $.popup('.takeout-buy-services');
            });


            //订购
            $('.takeout-buy-submit').click(function(){

                if(data.num < 1) {
                    $.alert('请选择数量');
                    return false;
                }

                $.confirm('总金额' + fmoney(data.amount / 100) + '元', '支付定金' + fmoney(data.deposit / 100) + '元', function () {
                    
                    if (! locked) {
                        return false;
                    }

                    locked = false;

                    $.ajax({
                        url: '{!! route('c.canteen.meal.buy') !!}',
                        type: 'POST',
                        data:data,
                        cache: false,
                        dataType: 'json',
                        success:function(res) {

                            if(res.code != 0) {
                                $.alert(res.data);
                                locked = true;
                            } else {
                                $.alert(res.data);
                                window.location.href = '{!! route('c.order.list') !!}';
                            }
                        },
                        error:function () {
                            locked = true;
                        }

                    });
                });
            });

            //加
            $('.plus').click(function(){
                data.num ++;

                if(data.num > 0) {
                    $(this).siblings('.minus').show();
                    $(this).siblings('.num').show();
                }

                if(data.num == 1) {
                    data.amount += data.price  * data.discount;
                } else {
                    data.amount += (data.price * 2)  * data.discount;
                }
                data.deposit += meal.deposit;

                if(data.num > 0) {
                    $(this).siblings('.minus').show();
                    $(this).siblings('.num').show();
                }

                $('.buy-deposit').text(fmoney(data.deposit / 100));
                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);
            });

            //减
            $('.minus').click(function(){

                data.num --;

                if(data.num == 0) {
                    data.amount -= data.price * data.discount;
                } else {
                    data.amount -= (data.price * 2) * data.discount;
                }
                data.deposit -= meal.deposit;

                if(data.num == 0) {
                    $(this).hide();
                    $(this).siblings('.num').hide();
                }

                $('.buy-deposit').text(fmoney(data.deposit / 100));
                $('.meal-price').text(fmoney(data.amount / 100));
                $('.num').text(data.num);
            });
        });

        //格式化金额千分位
        function fmoney(s, n) {
            n = n > 0 && n <= 20 ? n : 2;
            s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
            var l = s.split(".")[0].split("").reverse(),
                    r = s.split(".")[1];
            t = "";
            for(i = 0; i < l.length; i ++ )
            {
                t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
            }
            return t.split("").reverse().join("") + "." + r;
        }

        //还原千分位
        function rmoney(s) {
            return parseFloat(s.replace(/[^\d\.-]/g, ""));
        }
    </script>
@stop