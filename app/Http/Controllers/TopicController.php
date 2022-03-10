<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Repositories\TopicRepository;
/* Topic関連のビジネスロジックを記述したサービスクラスを読み込み */
use App\Services\TopicService;

/* バリデーションを設定したFormRequestを読み込み */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * @var TopicService
     */
    protected $topic_service;

    /**
     * @var TopicRepository
     */
    protected $topic_repository;


    /**
     * Create a new controller instance.
     *
     * @param  TopicService  $topic_service
     * @return void
     */
    /* コントローラの初期化処理(コンストラクタ) */
    public function __construct(TopicService $topic_service, TopicRepository $topic_repository)
    {
        /* index 以外のアクションメソッドの利用時に認証を行うように設定 */
        $this->middleware('auth')->except('index');

        /* クラスのプロパティにTopicService を保持し、クラス内のどこからでも利用できるようにする
         * コンストラクタを利用して依存性注入するので、コンストラクタ・インジェクションという
         */
        $this->topic_service = $topic_service;
        $this->topic_repository = $topic_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = $this->topic_service->getTopics(3);
        return view('topics.index', compact('topics'));
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
        try {
            $data = $request->only(['name', 'content']);
            $this->topic_service->createNewTopic($data, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('topics.index')->with('error', 'トピックの作成中にエラーが発生しました。もう一度やり直してください');
        }

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
        $topic = $this->topic_repository->findById($id);
        $topic->load('messages.user'); /* lazy Eager loading で、メッセージの投稿者ユーザーも取得しておく */
        return view('topics.show', compact('topic'));
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
