<?php
$gestor = opendir(CLASSES_PATH);
while (false !== ($filename = readdir($gestor))) {
	if ($filename != '.' &&  $filename != '..' && $filename != 'All.php') include CLASSES_PATH.$filename;
}