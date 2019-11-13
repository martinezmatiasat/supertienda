<?php 
include_once dirname(__FILE__).'/../config.php'; 
$filename = ADMIN_LANG.ADMIN_LANGUAGE.'.inc';
if (file_exists($filename)) include_once $filename;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo PAGE_NAME ?> Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/font-awesome.css" />
<link rel="stylesheet" href="css/login.css" />
<script type="text/javascript" src="js/respond.min.js"></script>
</head>
<body>
	<div id="container">
		<div id="logo">
			<img src="<?php echo ADMIN_IMAGES_PATH_HTML ?>logo-white.png" alt="" />
		</div>
		<div id="user">
			<div class="avatar">
				<div class="inner"></div>
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
			</div>
			<div class="text">
				<h4><?php echo showLang($lang, 'LOGIN_HELLO') ?>,<span class="user_name"></span></h4>
			</div>
		</div>
		<div id="loginbox">
			<form id="loginform" action="index.php">
				<p><?php echo showLang($lang, 'LOGIN_INFO') ?></p>
				<div class="input-group input-sm">
					<span class="input-group-addon"><i class="fa fa-user"></i></span><input class="form-control" type="text" name="username" id="username" placeholder="<?php echo showLang($lang, 'LOGIN_USERNAME') ?>" />
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span><input class="form-control" type="password" name="password" id="password" placeholder="<?php echo showLang($lang, 'LOGIN_PASSWORD') ?>" />
				</div>
				<div class="form-actions clearfix">
					<div class="pull-right">
						<a href="#recoverform" class="flip-link to-recover grey"><?php echo showLang($lang, 'LOGIN_LOST_PASSWORD') ?></a>
					</div>
					<input type="submit" name="login" class="btn btn-block btn-primary btn-default" value="<?php echo showLang($lang, 'LOGIN_LOGIN') ?>" />
				</div>
			</form>
			<form id="recoverform" action="#">
				<p><?php echo showLang($lang, 'LOGIN_LOST_INFO') ?></p>
				
				<div class="alert alert-success" role="alert""><?php echo showLang($lang, 'LOGIN_RECOVER_SUCCESS') ?></div>
				
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					<input name="email" class="form-control" type="text" placeholder="<?php echo showLang($lang, 'LOGIN_LOST_EMAIL') ?>" />
				</div>
				<div class="form-actions clearfix">
					<div class="pull-left">
						<a href="#loginform" class="grey flip-link to-login"><?php echo showLang($lang, 'LOGIN_LOST_LOGIN') ?></a>
					</div>
					<input type="submit" class="btn btn-block btn-inverse" name="recover" value="<?php echo showLang($lang, 'LOGIN_LOST_RECOVER') ?>" />
				</div>
			</form>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.custom.min.js"></script>
	<script src="js/login.js"></script>
</body>
</html>