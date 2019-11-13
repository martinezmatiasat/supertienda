<?php 
require_once dirname(__FILE__)."/header.php";
changeHeaderVariablesAdmin('', '', '', array());
function callback($buffer){}
?>
<?php
if (isset($_POST["saveChanges"])){
	updateMetaTags($_POST['description'], $_POST['keywords'], $_POST['author']);
	$ok = true;
}
$metaTags = getMetaTags();
?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, 'META_TAGS_TITLE') ?></h1>
	<div id="breadcrumb">
		<a href="index.php" title="<?php echo showLang($lang, 'HOME_BREADCRUM') ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, 'HOME_HOME') ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, 'META_TAGS_TITLE') ?></a>
	</div>	
</div>
<div class="container-fluid">
	<?php if (isset($ok)){ ?>
	<div class="alert alert-success"><?php echo showLang($lang, 'META_TAGS_SAVED') ?></div>
	<?php } ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon"><i class="fa fa-align-justify"></i></span>
					<h5><?php echo showLang($lang, 'META_TAGS_TITLE') ?></h5>
				</div>
				<div class="widget-content nopadding">
					<form action="metaTags.php" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'META_TAGS_DESCRIPTION') ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input type="text" name="description" class="form-control input-sm" value="<?php echo $metaTags['description'] ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'META_TAGS_KEYWORDS') ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input type="text" name="keywords" class="form-control input-sm" value="<?php echo $metaTags['keywords'] ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'META_TAGS_AUTHOR') ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input type="text" name="author" class="form-control input-sm" value="<?php echo $metaTags['author'] ?>" />
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, 'SAVE_CHANGES') ?></button> 
							<a class="btn btn-primary btn-sm" href="metaTags.php"><?php echo showLang($lang, 'CANCEL_CHANGES') ?></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
require_once dirname(__FILE__)."/footer.php";
?>