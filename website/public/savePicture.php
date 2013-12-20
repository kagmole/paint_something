<?PHP
	file_put_contents('img/games/'.$_REQUEST['gameId'], $_REQUEST['imgBase64']);
	// define('UPLOAD_DIR', 'images/');
	// $img = $_REQUEST['data'];
	// $img = str_replace('data:image/png;base64,', '', $img);
	// $img = str_replace(' ', '+', $img);
	// $data = base64_decode($img);
	// $file = uniqid() . '.png';
	// $success = file_put_contents($file, $data);
	// print $success ? $file : 'Unable to save the file.';
?>