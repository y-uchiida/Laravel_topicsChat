<?php

namespace App\Services;

use App\Repositories\TopicRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageService
{
    private $topic_repository;

    /*
     * コンストラクタインジェクションで、
     * データベースの操作を担当する機能を持つRepository層を注入
     * 今回は、対象のTopicを見つけてそこに新規内容を書き込むので、TopicRepositoryが必要
     */
    public function __construct(TopicRepository $topic_repo)
    {
        $this->topic_repository = $topic_repo;
    }

    public function createNewMessage(array $data, string $topic_id)
    {
        /* トランザクション開始 */
        DB::beginTransaction();
        try {
            $topic = $this->topic_repository->findById($topic_id);
            $message = $topic->messages()->create($data);
            /* 最終投稿日時を更新 */
            $this->topic_repository->updateTime($topic_id);
        } catch(Exception $e) {
            /* 例外をキャッチしたら、ロールバックして内容をログに保存 */
            DB::rollback();
            Log::error($e->geeMessage());
            throw new Exception($e->getMessage);
        }

        /* 成功したら、トランザクションをコミットして変更を確定 */
        DB::commit();

        return $message;
    }
}
