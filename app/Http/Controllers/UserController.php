<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->toArray();
        if(is_array($users)) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "users" => $users
                ]
            ]);
        }else {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "get user list failure"
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
        $input = $request->all();
        //下面增加两行，顺便看看Request::get的使用
        $input['published_at'] = Carbon::now();
        $user = user::create($input);
        if($user) {
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
        $user = User::findOrFail($id);
        if($user) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "user" => $user
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
        $user = User::findOrFail($id);
        if($user) {
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "user" => $user
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
        //根据id查询到需要更新的user
        $user = User::find($id);
        //使用Eloquent的update()方法来更新，
        //request的except()是排除某个提交过来的数据，我们这里排除id
        $user->update($request->except('id'));
        if($user) {
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
        $user = User::find($id)->delete();
        if($user) {
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
