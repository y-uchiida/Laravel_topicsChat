<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    protected $message_repository;

    public function __construct(MessageRepository $message_repository)
    {
        $this->message_repository = $message_repository;
    }

    /**
     * message を削除する
     */
    public function destroy(Topic $topic, $id)
    {
        try{
            $this->message_repository->deleteMessage($id);
        } catch(Exception $e){
            return redirect()->route('admin.topics.show', $topic->id)->with('error', 'メッセージの削除中にエラーが発生しました');
        }
        return redirect()->route('admin.topics.show', $topic->id)->with('success', 'メッセージを削除しました');
    }
}
