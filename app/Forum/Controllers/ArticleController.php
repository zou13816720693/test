<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\Requests\ArticleCreateRequest;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Forum;

class ArticleController extends Controller
{
    public function index($tag)
    {
        $list = ArticleBls::getArticleLise($tag);
        return view('forum::article.index', [
            'list' => $list
        ]);
    }

    public function create()
    {
        return view('forum::article.create');
    }

    public function createPut(ArticleCreateRequest $request)
    {
         if (ArticleBls::createArticle($request)) {
             return (new JsonResponse())->success('发布成功');
         } else {
             throw new LogicException(1010002, '发布失败');
         }
    }

    public function info($id)
    {
        $model = ArticleBls::find($id);

        $this->isEmpty($model);
        return view('forum::article.info', [
            'info' => $model
        ]);
    }
}