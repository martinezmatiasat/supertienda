<?php 
ob_start();
include_once dirname(__FILE__).'/../../config.php';

$uu =  isset($_POST["username"]) ? $_POST["username"] : '';
$pass = sha1(isset($_POST["password"]) ? $_POST["password"] : '');
$user = U1::login($uu, $pass);

if ($user != null){
	$user->generateSession();
	echo json_encode(array('success' => true));
}else echo json_encode(array('success' => false));
?>