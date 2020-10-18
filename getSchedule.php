<?php
/*
 * 共通の記述
  */
// composerでインストールしたライブラリを読み込む
require_once __DIR__.'/vendor/autoload.php';

// サービスアカウント作成時にダウンロードしたjsonファイル
$aimJsonPath = __DIR__ . 'xxxxxxxxxxx';

// サービスオブジェクトを作成
$client = new Google_Client();

// このアプリケーション名
$client->setApplicationName('カレンダー操作テスト イベントの取得');

// ※ 注意ポイント: 権限の指定
// 予定を取得する時は Google_Service_Calendar::CALENDAR_READONLY
// 予定を追加する時は Google_Service_Calendar::CALENDAR_EVENTS
$client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);

// ユーザーアカウントのjsonを指定
$client->setAuthConfig($aimJsonPath);

// サービスオブジェクトの用意
$service = new Google_Service_Calendar($client);

$calendarId = 'xxxxxxxxxxxxxx';

// 取得時の詳細設定
$optParams = array(
	    'maxResults' => 10,
		    'orderBy' => 'startTime',
			    'singleEvents' => true,
				    'timeMin' => date('c',strtotime("2019-01-01")),//2019年1月1日以降の予定を取得対象
				);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();
?>
