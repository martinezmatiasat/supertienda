<?php
include 'header.php';
changeHeaderVariablesAdmin('', '', '', array());
function callback($buffer){}
?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></h1>
	<div id="breadcrumb">
		<a href="index.php" title="<?php echo showLang($lang, 'HOME_BREADCRUM') ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, 'HOME_HOME') ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, 'HEADER_DASHBOARD') ?></a>
	</div>
</div>
<?php 
include 'footer.php';
?>