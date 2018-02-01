<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizUser as QuizResource;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\QuizUser;

class QuizUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $quizuser = $request->isMethod('put') ? QuizUser::findOrFail($request->id) : new QuizUser;

        $quizuser->username = $request->input('username');
        $quizuser->email = $request->input('email');
        $quizuser->password = Hash::make($request->input('password'));

        if($quizuser->save()) {
            return new QuizResource($quizuser);
        }
    }

    public function auth(Request $request)
    {
        $userData = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $userAuth = DB::table('quiz_users')
        ->where([
            ['email', '=', $request->email],
        ])
        ->orwhere([
            ['username', '=', $request->username],
        ])
        ->first();

        //return response()->json($userAuth, 200);
        
        if($userAuth !== null) {
            if(Hash::check($request->password, $userAuth->password)) {
                return response([
                    'status' => 'User Authenticated',
                    'response_time' => microtime(true) - LARAVEL_START,
                    'user' => $userData
                ],200);
            }
        }

        return response([
            'status' => "Response::HTTP_BAD_REQUEST",
            'response_time' => microtime(true) - LARAVEL_START,
            'error' => 'Wrong username or password',
            'request' => $request->all()
        ],404);
       
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
