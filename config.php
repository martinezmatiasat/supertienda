<?php
	session_start();
	ini_set( 'display_errors', true );
	define( 'DB_USERNAME', 'supertienda' );
	define( 'DB_PASSWORD', 'supertienda' );
	define( 'DB_HOST', 'localhost' );
	define( 'DB_NAME', 'supertienda' );

	define( 'WEB_URL', 'http://localhost/Externo/Supertienda/' );
	define( 'WEB_PATH', realpath($_SERVER['DOCUMENT_ROOT']).'/Externo/Supertienda/' );
	define( 'WEB_PATH_HTML','/Externo/Supertienda/' );

	include WEB_PATH.'constants.php';
	include WEB_PATH.'functions.php';
	include CLASSES_PATH.'All.php';
	include WEB_PATH.'variables.php';
	include SDK_PATH.'mailer/PHPMailerAutoload.php';
?>
