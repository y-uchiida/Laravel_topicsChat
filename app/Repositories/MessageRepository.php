<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    /* 依存性注入をして、クラス内全体で
     * データソースへのアクセスがすぐできるようにしておく
     */
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /* 渡されたデータの内容で、新たなMessageを作成する */
    public function create(array $data)
    {
        $this->message->create($data);
    }

    public function findById(int $id)
    {
        return $this->message->find($id);
    }

    /**
     * message を削除する
     */
    public function deleteMessage(int $id)
    {
        // dd($id);
        $message = $this->findById($id);
        return $message->delete();
    }
}
