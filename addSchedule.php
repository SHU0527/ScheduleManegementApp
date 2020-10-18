
<?php
/*
 * 共通の記述
  */
// composerでインストールしたライブラリを読み込む
require_once __DIR__.'/vendor/autoload.php';

// サービスアカウント作成時にダウンロードしたjsonファイル
$aimJsonPath = __DIR__ . '/key/xxxxxxxxxx';

// サービスオブジェクトを作成
$client = new Google_Client();

// このアプリケーション名
$client->setApplicationName('カレンダー操作テスト イベントの取得');

// ※ 注意ポイント: 権限の指定
// 予定を取得する時は Google_Service_Calendar::CALENDAR_READONLY
// 予定を追加する時は Google_Service_Calendar::CALENDAR_EVENTS
$client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);

// ユーザーアカウントのjsonを指定
$client->setAuthConfig($aimJsonPath);

// サービスオブジェクトの用意
$service = new Google_Service_Calendar($client);

$calendarId = 'xxxxxxxxxxxxxxxxxxxxxxxxx';

/*
 * 共通の記述
  */
// 省略
/*
 * 予定の追加
  */
// カレンダーID

$event = new Google_Service_Calendar_Event(array(
	    'summary' => '予定を追加したよ', //予定のタイトル
		    'start' => array(
				        'dateTime' => '2019-06-01T10:00:00+09:00',// 開始日時
						        'timeZone' => 'Asia/Tokyo',
								    ),
									    'end' => array(
											        'dateTime' => '2019-06-01T11:00:00+09:00', // 終了日時
													        'timeZone' => 'Asia/Tokyo',
															    ),
															));

$event = $service->events->insert($calendarId, $event);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>予定の取得サンプル</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">予定の追加</h1>
        <p>『<a href="<?php echo $event->htmlLink; ?>" target="_blank"><?php echo $event->summary; ?></a>』の予定を追加しました。</p>
    </div>
</section>

</body>
</html>
