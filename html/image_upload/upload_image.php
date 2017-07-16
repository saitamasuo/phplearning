<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>画像ファイルアップロード</title>
</head>
<body>
<?php
	//ファイル名の取り出し
	$file_name = $_FILES['filename']['name'];

	//ファイル(MIME)タイプの取り出し
	$file_type = $_FILES['filename']['type'];

	//一時ファイル名の取り出し
	$temp_name = $_FILES['filename']['temp_name'];


	//保存先のディレクトリ
	$dir = 'uploads/';
	//保存先のファイル名
	$upload_name = $dir . $file_name;

	//サムネイル画像の保存先ディレクトリ
	$dir_s = 'uploads/s/';
	//サムネイル画像の保存先のファイル名
	$upload_name_s = $dir_s . $file_name;

	//JPEG形式のファイルをアップロードする
	if (($file_type == 'image/jpeg') || ($file_type == 'image/pjpeg')){
		//アップロード(移動)
		$result = move_uploaded_file($temp_name, $upload_name);

		if ($result) {
			//アップロードの成功
			echo '■アップロード成功';

			//アップロードされた画像情報を取り出す
			$image_size = getimagesize($upload_name);
			//アップロードされた画像の幅と高さを取り出す
			$width = $image_size[0];
			$height = $image_size[1];

			//サムネイル画像の幅と高さを決める
			$width_s = 120;
			$height_s = round($width_s*$height/$width);

			//アップロードされた画像を取り出す
			$image = imagecreatefromjpeg($upload_name);
			//サムネイルの大きさの画像を新規作成
			$image_s = imagecreatetruecolor($width_s,$height_s);

			//アップロードされた画像からサムネイル画像を作成
			$result_s = imagecopyresampled($image_s, $image, 0,0, 0,0, $width_s,$height_s, $width,$height);

			if ($result_s){
				//サムネイル画像作成成功
					//サムネイル画像の保存
					if (imagejpeg($image_s,$upload_name_s)){
						echo ' ->サムネイル画像保存成功';
					} else {
						echo ' ->サムネイル画像保存失敗';
					}
				}	else {
					//サムネイル画像作成失敗
					echo ' ->サムネイル画像作成失敗';
				}

				//画像の破棄
				imagedestroy($image);
				imagedestroy($image_s);

			} else {
				//アップロードの失敗
				echo '■アップロード失敗';
			}
	} else {
				//JPEG形式以外のファイルはアップロードしない
				echo '■JPEG形式の画像をアップロードしてください。';
			}
?>
<br>
<br>
画像ファイル：<?php echo $upload_name . ' (' . $width . '×' . $height . ')'; ?>
<br>
<img src="<?php echo $upload_name; ?>">
<br>
<br>
サムネイル：<?php echo $upload_name_s . ' (' . $width_s . '×' . $height_s . ')'; ?>
<br>
<img src="<?php echo $upload_name_s; ?>">
<?php echo $temp_name . $upload_name; ?>
</body>
</html>
