<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table('articles')->orderBy('id', 'desc')->get();
        if(is_array($articles)) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "articles" => $articles
                ]
            ]);
        }else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "get article list failure"
                ],
                "data" => (object)Array()
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        //下面增加两行，顺便看看Request::get的使用
//        $input['introduction'] = mb_substr($input['content'],0,64);
        $input['published_at'] = Carbon::now();
        $user_id = $input['user_id'];

        if(empty($user_id) || !User::find($user_id)) {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "user not exist"
                ],
                "data" => (object)Array()
            ]);
        }
        $article = Article::create($input);

        if($article) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => (object)Array()

            ]);
        }else {
            return response()->json([
                "meta" => [
                    "code" => "551",
                    "error" => "insert failure"
                ],
                "data" => (object)Array()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $article = Article::findOrFail($id);
        if($article) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "article" => $article
                ]

            ]);
        } else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "find failure"
                ],
                "data" => (object)Array()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        if($article) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "article" => $article
                ]

            ]);
        } else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "find failure"
                ],
                "data" => (object)Array()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //根据id查询到需要更新的article
        $article = Article::find($id);
        //使用Eloquent的update()方法来更新，
        //request的except()是排除某个提交过来的数据，我们这里排除id
        $article->update($request->except('id'));
        if($article) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => (object)Array()

            ]);
        } else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "update failure"
                ],
                "data" => (object)Array()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::find($id)->delete();
        if($article) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => (object)Array()

            ]);
        } else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "update failure"
                ],
                "data" => (object)Array()
            ]);
        }

    }
}
