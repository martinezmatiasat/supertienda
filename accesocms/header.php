<?php
include_once dirname(__FILE__).'/../config.php';
include_once ADMIN_LANG.ADMIN_LANGUAGE.'.inc';
require_once dirname(__FILE__).'/security.php';
ob_start("callback");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo PAGE_NAME ?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script defer src="https://use.fontawesome.com/releases/v5.11.2/js/all.js"></script>
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/colorpicker.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/datepicker.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/icheck/flat/blue.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/select2.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/styles.css" />
<link rel="stylesheet" href="<?php echo ADMIN_PAGES_PATH_HTML ?>css/cropper.min.css" />
<link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<!--[if lt IE 9]><script type="text/javascript" src="js/respond.min.js"></script><![endif]-->

<script src="<?php echo JS_ADMIN_PATH_HTML ?>/jquery.min.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/jquery-ui.custom.min.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/bootstrap-colorpicker.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/bootstrap-datepicker.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/jquery.validate.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/ajaxfileupload.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/window-menu.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/scripts.js"></script>
<script src="<?php echo JS_ADMIN_PATH_HTML ?>/cropper.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo JS_ADMIN_PATH_HTML ?>/tinymce/tinymce.min.js"></script>
</head>
<div id="loading"><img alt="loading" src="<?php echo ADMIN_IMAGES_PATH_HTML ?>495.GIF"></div>
<body data-color="grey" class="flat" style="overflow: initial;">
	<div id="wrapper">
		<div id="header">
			<h1><img alt="<?php echo PAGE_NAME ?>" src="<?php echo ADMIN_IMAGES_PATH_HTML ?>logo-white.png" class="img-responsive" width="205px"></h1>
			<a id="menu-trigger" href="#"><i class="fa fa-bars"></i></a>
		</div>

		<div id="user-nav">
			<ul class="btn-group">
				<!-- //////ICONO CON BADGE Y CANTIDAD
				<li class="btnInverse btn"><a href="#"><i class="fa fa-envelope"></i> <span class="text">Messages</span> <span class="label label-danger">5</span></a></li>
				-->
				<li class="btnInverse btn"><a href="<?php echo ADMIN_PAGES_PATH_HTML ?>log-out.php"><i class="fa fa-share"></i> <span class="text"><?php echo showLang($lang, 'HEADER_LOGOUT') ?></span></a></li>
			</ul>
		</div>
		<div id="sidebar">
			<ul>
				<li><a href="index.php"><i class="fa fa-home"></i> <span><?php echo showLang($lang, 'MENU_DASHBOARD') ?></span></a></li>
				<?php
				////SOLO SE VE SI NO ES VENDEDOR, O SEA SUPERADMIN
				if (!VENDEDOR){ ?>
				<li><a href="administradores.php"><i class="fa fa-user"></i> <span><?php echo showLang($lang, 'MENU_USERS') ?></span></a></li>
				<li><a href="vendedores.php"><i class="fas fa-user-tie"></i> <span><?php echo showLang($lang, 'HEADER_VENDEDOR') ?></span></a></li>
				<li><a href="categorias.php"><i class="fa fa-user"></i> <span>Categor&iacute;as</span></a></li>
				<li class="submenu"><a href="#"><i class="fa fa-folder-open"></i><span><?php echo showLang($lang, 'MENU_OTHERS') ?></span> <i class="arrow fa fa-chevron-right"></i></a>
					<ul>
						<li><a href="variables.php"><?php echo showLang($lang, 'MENU_VARIABLES') ?></a></li>
					</ul>
				</li>
				<?php }else {
				    ////SOLO SE VE SI ES VENDEDOR
				?>
				<li><a href="productos.php"><i class="fas fa-list"></i> <span><?php echo showLang($lang, 'HEADER_PRODUCTO') ?></span></a></li>
				
				<?php } ?>
				<li><a href="compras.php"><i class="fas fa-shopping-cart"></i> <span><?php echo showLang($lang, 'HEADER_COMPRA') ?></span></a></li>
			</ul>
		</div>
		<div id="content">
