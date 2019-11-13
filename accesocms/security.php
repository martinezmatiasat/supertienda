<?php
if (isset($_SESSION['userId'])){
	$session = U1::getSession();
	if ( $session == null){
		header("Location: ".ADMIN_PAGES_PATH_HTML."login.php");
		exit();
	}
}else {
	header("Location: ".ADMIN_PAGES_PATH_HTML."login.php");
	exit();
}
?>