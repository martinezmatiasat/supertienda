<?php
require_once dirname(__FILE__)."/../../config.php";
include_once ADMIN_PAGES_PATH."security.php";
$fileElementName = "fileToUpload";
$uploadsDir = PRODUCTOS_PATH;
if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0700);
$items = array();
foreach ($_FILES[$fileElementName]["name"] as $num => $fileName){
	if (!$_FILES[$fileElementName]["error"][$num]){
		$continue = true;
		$error = "";
		$msg = "";
		$name = $fileName;
		$name = returnEncryptedName($fileName,generateRandomString());
		$fileName = $name;
		move_uploaded_file($_FILES[$fileElementName]["tmp_name"][$num], "$uploadsDir/$fileName");
		$test = new ProductoImagen(array("imagen" => $fileName));
		$test->producto_id = getVar('pid');
		$test->insert();
	}
}
echo json_encode(array());
?>