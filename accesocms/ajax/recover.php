<?php 
ob_start();
include_once dirname(__FILE__).'/../../config.php';
$filename = ADMIN_LANG.ADMIN_LANGUAGE.'.inc';
if (file_exists($filename)) include_once $filename;

$email = isset($_POST['email']) ? $_POST['email'] : '';
$user = u1::getByEmail($email);
if ($user){
	$pass = generateRandomString();
	$user->clave = sha1($pass);
	$user->updateFields(array("clave"));
	
	$to = $user->email;
	$message = 'Your new password is: '.$pass;
	$subject = "Password Change";
	
	sendEmail($to, $subject, $message);
}
?>