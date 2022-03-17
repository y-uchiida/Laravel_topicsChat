<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\TopicRepository;
use App\Services\TopicService;
use Exception;

class TopicController extends Controller
{
    protected $topic_service;
    protected $topic_repository;

    public function __construct(TopicService $topic_service, TopicRepository $topic_repository)
    {
        /* adminの認証ミドルウェアをを設定 */
        $this->middleware('auth:admin');
        $this->topic_service = $topic_service;
        $this->topic_repository = $topic_repository;
    }

    /* 3件分のTopicsデータを取得し、リレーションのレコードをeager loading してビューに渡す */
    public function index()
    {
        $topics = $this->topic_service->getTopics(3);
        $topics->load('messages.user', 'messages.images');
        return view('topics.index', compact('topics'));
    }

    /* 指定のtopicとそこに関連づくmessageを表示する */
    public function show($id)
    {
        $topic = $this->topic_repository->findById($id);
        $topic->load('messages.user', 'messages.images');
        return view('topics.show', compact('topic'));
    }

    /*  */
    public function destroy($id)
    {
        try {
            $this->topic_repository->deleteTopic($id);
        } catch(Exception $e) {
            return redirect()->route('admin.topics.index')
                    ->with('error', 'トピックの削除中にエラーが発生しました');
        }
        return redirect()->route('admin.topics.index')->with('success', 'トピックを削除しました');
    }
}
