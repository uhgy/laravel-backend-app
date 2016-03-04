<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        if($articles) {
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
                    "error" => "insert failure"
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
        $input['introduction'] = mb_substr($input['content'],0,64);
        $input['published_at'] = Carbon::now();
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
                    "code" => "550",
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
        //
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
        //
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
    }
}
