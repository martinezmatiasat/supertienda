<?php
include_once dirname(__FILE__)."/../../config.php";
$title = isset($_POST['t']) ? $_POST['t'] : '';
echo changeSpecialCharacters(utf8_decode($title));
?>