<?php

namespace App\Forum\Bls\Article;

use App\Consts\Admin\Role\RoleSlugConst;
use App\Consts\Admin\User\InfoTypeConst;
use App\Consts\Common\SearchType;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\Model\ArticleModel;
use App\Forum\Bls\Article\Model\ArticlesRecommendModel;
use App\Forum\Bls\Article\Model\ArticlesStarModel;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Forum\Bls\Article\Traits\ThumbsTraits;
use App\Forum\Bls\Users\UsersBls;
use Auth;

/**
 * Class RoleBls.
 */
class ArticleBls
{

    use ThumbsTraits;

    /**
     * 文章列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @param string $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getArticleLise($request, $order = '`id` DESC', $limit = 30, $page = 'paginate')
    {
        $model = ArticleModel::query();

        //标签
        if(!empty($request->tag)) {

            if(is_array($request->tag)) {
                $model->whereIn('tags', $request->tag);
            } else {
                $model->where('tags', $request->tag);
            }

        }

        if($request->type_key == SearchType::NAME && !empty($request->key)) {
            $user = UsersBls::getUserByName($request->key)->pluck('id');
            $model->whereIn('issuer', $user);
        }

        if($request->type_key == SearchType::TITLE && !empty($request->key)) {
            $model->where('title', 'like', '%'.$request->key.'%');
        }


        //标题
        if(!empty($request->title)) {
            $model->where('title', 'like', '%'.$request->title.'%');
        }

        //排序
        if(!empty($request->order) && $request->order == 'hot') {
            $order = '`hot_search_time` DESC';
            $model->where('is_hot', WhetherConst::YES);
        }

        //热门条件
        if(!empty($request->type) && $request->type == 'hot') {
            $order = '`hot_search_time` DESC';
            $model->where('is_hot', WhetherConst::YES);
        }

        //发布人
        if(!empty($request->issuer)) {
            $model->where('issuer', $request->issuer);
        }




        //只展示删除数据
        if(!empty($request->recycle)) {
            $model->onlyTrashed();
        }

        $model->orderByRaw($order);

        if($page == 'paginate') {
            return $model->paginate($limit);
        } else {
            return $model->simplePaginate($limit);
        }

    }

    /**
     * 创建文章
     * @param ArticleCreateRequest $request
     * @return bool
     */
    public static function createArticle(ArticleCreateRequest $request)
    {
        return ArticleModel::query()->getQuery()->getConnection()->transaction(function () use($request) {

            $user = Auth::guard('forum')->user();

            //文章发表策略
            static::articleStrategy($user);

            $model = new ArticleModel();
            $model->title = $request->title;
            $model->source = $request->source ?: '';
            $model->tags = $request->tags;
            $model->status = WhetherConst::NO;
            $model->is_hide = $model->tags == 4 ? ($request->is_hide ? WhetherConst::YES : WhetherConst::NO) : WhetherConst::NO;
            $model->contents = $request->contents;
            $model->issuer = $user->id;
            $model->ip =  $request->getClientIp();
            $model->thumbs_up =  [];
            $model->thumbs_down =  [];
            $model->star =  [];
            $model->recommend =  [];

            if($model->save()) {
                return $model;
            }
            return false;
        });
    }

    public static function editArticle(ArticleCreateRequest $request, ArticleModel $model)
    {
        $model->title = $request->title;
        $model->source = $request->source ?: '';
        $model->tags = $request->tags;
        $model->status = WhetherConst::NO;
        $model->is_hide = $model->tags == 4 ? ($request->is_hide ? WhetherConst::YES : WhetherConst::NO) : WhetherConst::NO;
        $model->contents = $request->contents;
        return $model->save();
    }

    public static function updateArticle(ArticleCreateRequest $request, ArticleModel $model)
    {
        $model->title = $request->title;
        $model->source = $request->source ?: '';
        $model->tags = $request->tags;
        $model->contents = $request->contents;

        if(Auth::guard('admin')->user()->is(RoleSlugConst::ROLE_SUPER)) {
            $model->browse = $request->browse;
        }

        //$model->recommend_count = $request->recommend_count;
        return $model->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return ArticleModel::find($id);
    }

    /**
     * 无视文章是否删除
     * @param $id
     * @return mixed
     */
    public static function findByWithTrashed($id)
    {
        return ArticleModel::withTrashed()->find($id);
    }



    /**
     * 赞
     * @param ArticleModel $model
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsUp(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_up)) {
//            $model->thumbs_up = static::thumbsMinus($model->thumbs_up, $user->id);
//            $user->thumbs_up --;
//            $data = false;
            throw new LogicException(1010002, '只能点一次哦!');
        } else {

            if(static::checkThumbs($model->thumbs_down, $model->thumbs_up, $user->id)) {
                throw new LogicException(1010002, '只能选一个赞或者弱');
            }

            $model->thumbs_up = static::thumbsPlus($model->thumbs_up, $user->id);
            $user->thumbs_up ++;
            $model->recommend_count ++;
            $data = true;

            //添加积分
            UsersBls::addIntegral(2);

            if($model->recommend_count == config('config.recommend', 0)) {
                $model->is_hot = WhetherConst::YES;
                $model->hot_search_time = date('Y-m-d H:i:s');
            }
        }

        $model->save();

        //信息创建
        $operatorId = Auth::guard('forum')->id();
        $content = '你的帖子<a href="'. route('f.article.info', ['id' => $model->id], false) .'">' . $model->title . '</a>,被推荐了';
        InfoBls::createInfo($model->issuer, $operatorId, InfoTypeConst::THUMBS_UP, $content);

        if($user->save()) {
            return ['data' => $data];
        }
        return false;
    }

    /**
     * 弱
     * @param ArticleModel $model
     * @throws LogicException
     * @return array|bool
     */
    public static function thumbsDown(ArticleModel $model)
    {
        $user = Auth::guard('forum')->user();
        if(in_array($user->id, $model->thumbs_down)) {
//            $model->thumbs_down = static::thumbsMinus($model->thumbs_down, $user->id);
//            $data = false;
            throw new LogicException(1010002, '只能点一次哦!');
        } else {

            if(static::checkThumbs($model->thumbs_down, $model->thumbs_up, $user->id)) {
                throw new LogicException(1010002, '只能选一个赞或者弱');
            }
            $user->thumbs_down ++;
            $user->save();
            $model->thumbs_down = static::thumbsPlus($model->thumbs_down, $user->id);
            $data = true;
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;

    }

    /**
     * 收藏文章
     * @param ArticleModel $model
     * @return array|bool
     */
    public static function starArticle(ArticleModel $model)
    {
        $userId = Auth::guard('forum')->id();
        if(in_array($userId, $model->star)) {
            ArticlesStarModel::where('user_id', $userId)->where('articles_id', $model->id)->delete();
            $model->star = static::thumbsMinus($model->star, $userId);
            $data = false;
        } else {
            $star = new ArticlesStarModel();
            $star->user_id = $userId;
            $star->articles_id = $model->id;
            $star->save();
            $model->star = static::thumbsPlus($model->star, $userId);
            $data = true;
        }

        if($model->save()) {
            return ['data' => $data];
        }
        return false;
    }


    /**
     * 推荐文章
     * @param ArticleModel $model
     * @return array|bool
     * @throws LogicException
     */
    public static function recommendArticle(ArticleModel $model)
    {
        $userId = Auth::guard('forum')->id();
        if(in_array($userId, $model->recommend)) {
//            ArticlesRecommendModel::where('user_id', $userId)->where('articles_id', $model->id)->delete();
//            $model->recommend = static::thumbsMinus($model->recommend, $userId);
//            $data = false;

            throw new LogicException(1010002,'你已推荐');
        } else {
            $star = new ArticlesRecommendModel();
            $star->user_id = $userId;
            $star->articles_id = $model->id;
            $star->save();
            $model->recommend = static::thumbsPlus($model->recommend, $userId);
            $model->recommend_count ++;
            $data = true;
        }

        if($model->save()) {
            //推荐一个网站加一分
            UsersBls::addIntegral(1);
            return ['data' => $data];
        }
        return false;
    }

    /**
     * 统计用户发了多少文章
     * @param $issuer
     * @return mixed
     */
    public static function ArticleCount($issuer)
    {
        return ArticleModel::where('issuer', $issuer)->count();
    }

    /**
     * 文章发表策略
     * @param $user
     * @throws LogicException
     */
    public static function articleStrategy($user)
    {
        $lastLoginTime = mb_substr($user->last_login_time, 0, 10);
        $day = date('Y-m-d');
        $dayArticle = config('config.day_article');

        if($lastLoginTime == $day && $user->day_article == $dayArticle) {
            //如果当天已发布限制时间抛出错误

            if($user->integral - 10 < 0) {
                throw new LogicException(1010002, [["你的积分不够了"]]);
            }

            //超出当天限制减10个积分
            UsersBls::minusIntegral(10);

        } else if($lastLoginTime != $day){
            //如果不是当日发布
            $user->last_login_time = date('Y-m-d H:i:s');
            $user->day_article = 1;
        } else {
            $user->day_article ++;
        }

        $user->save();
    }

    /**
     * 根据发表人ID查询文章
     * @param $issuer
     * @param $id
     * @return mixed
     */
    public static function getArticleByIssuer($issuer, $id)
    {
        return ArticleModel::where('issuer', $issuer)->where('id', $id)->first();
    }


}

