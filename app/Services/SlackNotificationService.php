<?php

namespace App\Services;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Notifiable;

class SlackNotificationService
{
    /* Notifiable トレイトを読み込み */
    use Notifiable;

    /**
     * SlackNotification 経由でメッセージを通知する
     */
    public function send($message)
    {
        $this->notify(new SlackNotification($message));
    }

    /**
     * Slack チャンネルに対する通知をルーティングする
     */
    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_URL');
    }
}
