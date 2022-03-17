<?php

/*
 * topicのデータソースへのアクセス・操作を担うクラス
 * 主に、データベースへの処理を記述する
 */

namespace App\Repositories;

use App\Models\Topic;
use Carbon\Carbon;

class TopicRepository
{
    protected $topic;

    /* コンストラクタインジェクションで、Topicモデル(Eloquent オブジェクト)を注入 */
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    /* 渡されたデータの内容で、新たなTopicを作成する */
    public function create(array $data)
    {
        return $this->topic->create($data);
    }

    /**
     * 指定のid に一致するTopic を取得する
     */
    public function findById(int $id)
    {
        return $this->topic->find($id);
    }

    public function updateTime(int $id)
    {
        $topic = $this->findById($id);
        $topic->latest_comment_time = Carbon::now();
        return $topic->Save();
    }

    /**
     * topic を削除する
     */
    public function deleteTopic(int $id){
        $topic = $this->findById($id);
        return $topic->delete();
    }

    /* ページングされたTopicのデータを取得する
     */
    public function getPaginatedTopics(int $per_page)
    {
        return $this->topic->orderby('latest_comment_time', 'desc')->paginate($per_page);
    }
}
