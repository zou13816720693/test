<div class="header clearfix">
    <div class="logo fl"><a href="{!! route('h.home') !!}"><img src="{{  assets_path("/h5/img/logo.png") }}" alt="" title="" /></a></div>
    <div class="hd-link fr clearfix">
        @if(Auth::guard('forum')->check())
            <?php
            $count = \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO);
            ?>
            <a  class="info-link" href="{!! route('h.member.info') !!}">
                <i style="{!! $count ? 'color: #e15844;': 'color: #ffffff;' !!}" class="icon-alarm icon"></i>
                <span style="{!! $count ? 'color: #e15844;': 'color: #ffffff;' !!}">{!! \App\Forum\Bls\Article\InfoBls::countInfo(\Auth::guard('forum')->id(), \App\Consts\Common\WhetherConst::NO) !!}</span>
            </a>
            <a class="my-link" href="{!! route('h.member.index') !!}"></a>
        @else
            <a class="my-link" href="{!! route('h.auth.login') !!}"></a>
        @endif

        <a class="edit-link" href="{!! route('h.article.create') !!}"></a>
        <a class="search-link" href="{!! route('h.article.search') !!}"></a>
    </div>
</div>
<div class="menu-box">
    <a @if(Input::get('type') == 'hot') class="on" @endif href="{!! route('h.home') !!}">热门</a>
    <a @if(Input::get('type') == 'new') class="on" @endif href="{!! route('h.home', ['type' => 'new']) !!}">最新</a>
    <a @if(\Request::route()->getAction('as') == 'h.notice.list') class="on" @endif href="{!! route('h.notice.list') !!}">公告</a>
    <a @if(\Request::route()->getAction('as') == 'h.article.category') class="on" @endif href="{!! route('h.article.category') !!}">板块</a>
</div>