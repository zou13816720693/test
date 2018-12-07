@extends('forum::layouts.master')

@section('style')
    <link rel="stylesheet" href="{!! assets_path("/forum/css/my.css") !!}" />
@stop

@section('content')
    @include('forum::partials.space_info')

    <div class="com-new">
        <div class="wm-850">
            <div class="new-container"><table class="new-table">

                    <tbody>
                    @foreach($list as $item)
                        <tr class="@if(in_array($item->id,session('article', []))) read @endif">
                            <td width="55"> {{ $item->id }}</td>
                            <td class="l" width="515">
                                <a href="{!! route('f.article.info', ['id' => $item->id]) !!}">
                                    <i style="color:{!!  Forum::Tags()->getTagsColor($item->tags) !!} " class="{!!  Forum::Tags()->getTagsIcon($item->tags) !!}"></i>
                                    {{ $item->title }}
                                    <span style="color: #00a7d0">[{!! $item->replyCount !!}]</span>
                                </a>
                            </td>
                            <td width="95">{{ $userName }}</td>
                            <td width="95">
                                {{ $item->browse }}
                                <span class="red">{{ $item->recommend_count }}</span>
                            </td>
                            <td width="90">
                                {!! mb_substr($item->created_at, 0, 16) !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="com-page">
                    {!! $list->render() !!}
                </div>
            </div>
        </div>
    </div>
@stop