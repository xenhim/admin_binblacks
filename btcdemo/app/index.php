<?php
/*
    ※このサンプルプログラムはPHP7.3で動作確認しています。

    composerを使用し、以下のライブラリをインストールしてください。
    ratchet/pawl:v0.3.4

    詳細は以下をご覧ください。
    https://github.com/ratchetphp/Pawl
*/

require('vendor/autoload.php');

// 接続先URL
const URL = 'wss://www.blockonomics.co/payment/1ETs5kv9teWD8xbKX2neDMta7zqms89h3';
// ユーザID
const USERID = 'trialuser';
// パスワード
const PASSWORD = 'trialpass';
// 端末ID
const TERMID = '000000001';

// 認証要求メッセージ
const AUTH_MESSAGE = [
    'version' => [
        'common_version' => '1',
        'details_version' => '1',
    ],
    'common' => [
        'datatype' => 'authentication',
        'msgid' => '*',
        'sendid' => '*',
        'senddatetime' => '',
    ],
    'details' => [
        'password' => PASSWORD,
    ],
    'sender' => [
        'version' => '1',
        'userid' => USERID,
        'termid' => TERMID,
    ],
    'receiver' => [
        'version' => '1',
        'userid' => '*',
        'termid' => '*',
    ],
];

\Ratchet\Client\connect(URL)->then(function ($conn) {
    $conn->on('message', function ($msg) use ($conn) {
        // 受信したメッセージを表示します。
        echo "{$msg}\n";
    });

    $conn->on('close', function ($code = null, $reason = null) {
        echo "Connection closed ({$code} - {$reason})\n";
    });

    // 認証要求メッセージをJSONに変換して送信します。
    //$conn->send(json_encode(AUTH_MESSAGE));
}, function ($e) {
    exit($e->getMessage());
});
