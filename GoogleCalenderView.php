<?php
function getData() {
/*
 * 共通の記述
  */
// composerでインストールしたライブラリを読み込む
require_once __DIR__.'/vendor/autoload.php';

// サービスアカウント作成時にダウンロードしたjsonファイル
$aimJsonPath = __DIR__ . '/key/xxxxxxxxxxx';

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

$calendarId = 'xxxxxxxxxxxxxxxxxxx';

// 取得時の詳細設定
$optParams = array(
	    'maxResults' => 5,
		    'orderBy' => 'startTime',
			    'singleEvents' => true,
				    'timeMin' => date('c', strtotime("now")),//現在時刻以降の予定を取得対象
				);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();
return $events;
}
$events = getData();
foreach ($events as $event) {
		if (mb_strlen($event['summary']) > 40) {
			$str_t = str_replace(PHP_EOL, '', $event['summary']);
			$str_t = preg_split('//u', $str_t, 0, PREG_SPLIT_NO_EMPTY);
			$title = '';
			for ($i = 0; $i < 37; $i++) {
				$title .= $str_t[$i];
			}
			$title .= '...';
		} else {
			$title = str_replace(PHP_EOL, '', $event['summary']);
		}

		// 説明が60文字以上の場合はトリミング
		if (mb_strlen($event['description']) > 60) {
			$str_d = str_replace(PHP_EOL, '', $event['description']);
			$str_d = preg_split('//u', $str_d, 0, PREG_SPLIT_NO_EMPTY);
			$description = '';
			for ($i = 0; $i < 57; $i++) {
				$description .= $str_d[$i];
			}
			$description .= '...';
		} else {
			$description = str_replace(PHP_EOL, '',$event['description']);
		}
	$columns[] = [
		'title' => $title,
		'text' => $description,
		'actions' => [
			[
				'type' => 'uri',
				'uri' => $event['htmlLink'],
				'label' => '詳細はこちら'
			]
		]
	];
}
$template = ['type' => 'carousel', 'columns' => $columns];
$reply['messages'][0] = ['type' => 'template', 'altText' => 'すみません...', 'template' => $template];
