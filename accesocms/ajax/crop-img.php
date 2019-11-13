<?php
include("../../config.php");
$image = getVar('image');
$cropPath = getVar('cropPath');
if (!is_dir($cropPath)) mkdir($cropPath, 0700);

////CROPEAR
$file_to_upload = $_FILES['croppedImage']['tmp_name'];
move_uploaded_file($file_to_upload, $cropPath.$image);

echo json_encode(array("error" => false, 'files' => $_FILES));
exit();