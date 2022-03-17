# Laravel_topicsChat
Laravel 9系で掲示板サイトを作成しました。

# 開発環境
- Windows 11 Pro
- WSL2 Ubuntu 20
- Laravel Sail
- docker-compose version 1.29.2

# ローカルで動作させる場合
- Sailで利用しやすい `.sail.example.env` を用意していますので、これを`.env` にリネームしてご利用ください  
- メッセージに添付された画像を保存するため、AWS S3のbucket を利用する実装になっています  
  `.env` ファイルにS3の設定を記入してください  
- Slack 通知のため、incoming webhook のURLを利用します  
  `.env` ファイルに、通知を受け取りたいSlackチャンネルのwebhook URLを設定してください  

# 出典・参考資料など
## ベース教材
Laravel でスレッド掲示板を作成（中級）：  
https://aburasoba.org/category/programming/laravel/

Service層、Repository層まで取り入れた実践的な内容でした。  
教材製作者のTsubasa さんへ感謝を申し上げます。  

## 参考資料
- tailwindcss：  
  https://tailwindcss.com/docs/  
  CSS作成、レイアウト調整で何度も確認しました。  

- Laravel Breezeでマルチ認証(Multi Authentification)の徹底解説：  
  https://reffect.co.jp/laravel/breeze_multi_auth  
  ベース教材とのバージョン違いでマルチ認証の実装方法を変更する必要がある部分について、  
  こちらのページを参照しつつ内容を変更していきました。

- laravel-slack-apiを使用して、Laravelからslackへ通知する：  
  https://qiita.com/turmericN/items/43fd953891aed3b718ab  
  Slack通知の別の実装パターンを紹介しています。  
  Slackのページに「incoming webhookは古い」と書いてあったので、これで大丈夫かな...と思い、  
  別のパターンも調べてみました。  
  Laravel 9の公式ドキュメントでもincoming webhookの利用方法が紹介されていたので、結論としては利用しなかったのですが、  
  調べた記録として記しておきます。
