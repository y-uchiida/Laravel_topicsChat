<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            /* 既に設定してある外部キー制約をdropForeign() でいったん削除して、
             * topicsテーブルの連携レコードの更新・削除に連動して変更されるように設定を追加
             * $table->dropForeign('[テーブル名]_[外部キーを取り除くカラム名]_foreign');
             */
            $table->dropForeign('images_message_id_foreign');

            /* topics テーブルとidでの関連付けをもたせ、削除時に連動して削除されるようにcascadeを設定 */
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            /* cascade の設定をしていない外部キー制約に戻す */
            $table->dropForeign('images_message_id_foreign');
            $table->foreign('message_id')->references('id')->on('topics');
        });
    }
};
