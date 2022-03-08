<?php

/*
 * topicのデータソースへのアクセス・操作を担うクラス
 * 主に、データベースへの処理を記述する
 */

namespace App\Repositories;

use App\Models\Topic;

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

    /* ページングされたTopicのデータを取得する
     */
    public function getPaginatedTopics(int $per_page)
    {
        return $this->topic->paginate($per_page);
    }
}
