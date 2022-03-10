<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\MessageRequest;
use App\Services\MessageService;

class MessageController extends Controller
{
    private $message_service;

    public function __construct(MessageService $message_service)
    {
        $this->middleware('auth');
        $this->message_service = $message_service;
    }

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
     * @param  \Illuminate\Http\MessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, int $id)
    {
        try{
            /* レコード作成に必要なデータ（カラムに入る内容）を配列にまとめる */
            $message_data = $request->validated();
            $message_data['user_id'] = Auth::id();

            /* Service 経由で、メッセージの保存を実行 */
            $this->message_service->createNewMessage($message_data, $id);
        }catch(Exception $e) {
            return redirect()->route('topics.show')->with('error', 'メッセージの投稿中にエラーが発生しました。');
        }
        return redirect()->route('topics.dhow')->with('success', 'メッセージを投稿しました。');
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
