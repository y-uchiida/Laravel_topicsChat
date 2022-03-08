<?php

/* Topic 関連のロジックを主に記述するファイルとしてサービス層を作成
 * コントローラはサービスを通してビジネスロジックを処理し、その結果をビューに渡す
 */

namespace App\Services;

/* モデルクラスの代わりに、データソースへのアクセスを担うクラスとして用意した
 * リポジトリクラスを読み込みする
 */
use App\Repositories\MessageRepository;
use App\Repositories\TopicRepository;


use Carbon\Carbon;
use Exception;

/* 手動トランザクションを利用するためDBファサードを読み込み */
use Illuminate\Support\Facades\DB;
/* DB操作時のエラー情報保存のためLogファサードを読み込み */
use Illuminate\Support\Facades\Log;

class TopicService
{
    /* リポジトリ層のオブジェクトをプロパティにしておき、依存性注入で受け取れるようにしておく */
    protected $topic_repository;
    protected $message_repository;

    /*
     * リポジトリ層のクラスをコンストラクタインジェクション
     */
    public function __construct(
        TopicRepository $topic_repo,
        MessageRepository $message_repo
    ) {
        $this->topic_repository = $topic_repo;
        $this->message_repository = $message_repo;
    }

    /**
     * Create new topic and first new message.
     *
     * @param array $data
     * @return Topic $topic
     */
    public function createNewTopic(array $data, string $user_id)
    {
        DB::beginTransaction(); /* DBファサードから、トランザクションを開始 */
        try {
            /* 引数で受け取った内容を用いて、オブジェクト生成用の配列を生成して変数格納 */
            $topic_data = $this->getTopicData($data['name'], $user_id);
            /* 作成された配列でモデルを作成、データベースに保存
             * マスアサインメントでかんたんにモデルを作るメソッド create を使う
             * マスアサインメント:
             * https://readouble.com/laravel/9.x/ja/eloquent.html#mass-assignment
             */
            $new_topic = $this->topic_repository->create($topic_data);

            $message_data = $this->getMessageData($data['content'], $user_id, $new_topic->id);
            $this->message_repository->create($message_data);
        } catch (Exception $error) {
            /* 例外発生時はDBの変更内容をロールバックし、内容をログに出力 */
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit(); /* トランザクションを正常終了 */
        return $new_topic;
    }

    /**
     * get topic data
     *
     * @param string $topic_name
     * @param string $user_id
     * @return array
     */
    public function getTopicData(string $topic_name, string $user_id)
    {
        /* 受け取ったトピック名称とユーザーIDを、現在時刻と合わせて配列にして返すだけ */
        return [
            'name' => $topic_name,
            'user_id' => $user_id,
            'latest_comment_time' => Carbon::now(),
        ];
    }

    /**
     * get message data
     *
     * @param string $message
     * @param string $user_id
     * @param string $topic_id
     * @return array
     */
    public function getMessageData(string $message, string $user_id, string $topic_id)
    {
        /* 受け取った内容でモデルを生成できるように、配列に詰め替えるだけ */
        return [
            'body' => $message,
            'user_id' => $user_id,
            'topic_id' => $topic_id,
        ];
    }

}
