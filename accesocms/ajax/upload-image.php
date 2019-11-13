<?php
require_once dirname(__FILE__)."/../../config.php";
include_once ADMIN_PAGES_PATH."security.php";
$fileElementName = "fileToUpload";
$uploadsDir = TINY_PATH;

reset($_FILES);
$temp = current($_FILES);
$path = TINY_PATH_HTML;
if (is_uploaded_file($temp['tmp_name'])){
	if (!$temp["error"]){
		$name = returnEncryptedName($temp['name'],generateRandomString());
		$fileName = $name;
		move_uploaded_file($temp['tmp_name'], "$uploadsDir/$fileName");
		$path .= '/'.$fileName;
	}
}
echo json_encode(array('location' => $path));
?>