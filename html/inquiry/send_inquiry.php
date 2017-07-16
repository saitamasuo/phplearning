<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>お問い合わせフォーム</title>
</head>
<body>
<?php
	//お問い合わせタイトル、詳細のセット
	$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
	$message = htmlspecialchars($_POST['message'], ENT_QUOTES);

	//日本語(SJIS)の指定
	mb_language('ja');
	mb_internal_encoding('SJIS');

	//Fromアドレスの設定(自動送信<送信元のアドレス>)
	$name = '自動送信';
	$email = 'tokiadaroku+from@gmail.com';
	$header = 'From: '. mb_encode_mimeheader($name) . '<' . $email . '>';

	//メール送信
	$result = mb_send_mail("<自分のメールアドレス>", $title, $message, $header);

	//メール送信の確認
	if ($result) {
		//メール送信の成功
		echo '■お問い合わせ内容を担当者へ送信しました。';
	} else {
		//メール送信の失敗
		echo '■担当者への送信に失敗しました。';
	}		
?>
</body>
</html>
