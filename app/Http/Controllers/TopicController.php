<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; /* 手動トランザクションを利用するためDBファサードを読み込み */
use Illuminate\Support\Facades\Log; /* DB操作時のエラー情報保存のためLogファサードを読み込み */

/* バリデーションを設定したFormRequestを読み込み */
use App\Http\Requests\TopicRequest;

use App\Models\Topic;
use App\Models\Message;
use Throwable;

class TopicController extends Controller
{
    /* コントローラの初期化処理(コンストラクタ) */
    public function __construct()
    {
        /* index 以外のアクションメソッドの利用時に認証を行うように設定 */
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('topics.index');
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
     * 標準のRequestから、フォームリクエストに差替え
     * @param  App\Http\Requests\TopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        DB::beginTransaction(); /* DBファサードから、トランザクションを開始 */
        try {
            /* Topicの保存 */
            $new_topic = new Topic();
            $new_topic->name = $request->name;
            $new_topic->user_id = Auth::id();
            $new_topic->latest_comment_time = Carbon::now();
            $new_topic->save();

            /* 最初のメッセージを登録 */
            $new_message = new Message();
            $new_message->body = $request->content;
            $new_message->user_id = Auth::id();
            $new_message->topic_id = $new_topic->id;
            $new_message->save();

        } catch (Throwable $e) {
            /* 例外発生時はDBの変更内容をロールバックし、内容をログに出力 */
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->route('topics.index')->with('error', 'トピックの作成中にエラーが発生しました。もう一度やり直してください');
        }
        DB::commit(); /* トランザクションを正常終了 */

        /* 一覧画面にリダイレクト */
        return redirect()->route('topics.index')->with('success', 'スレッドを作成しました');
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
