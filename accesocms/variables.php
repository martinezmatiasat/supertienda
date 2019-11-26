<?php 
require_once dirname(__FILE__)."/header.php";

$extra = ExtraVariables::getListByModules(array(1));

if (isset($_POST["saveChanges"])){
	set_time_limit(0);
	
	if (isset($_POST['extra'])){
		$extra = $_POST['extra'];
		foreach ($extra as $name => $value){
			$extraVariable = ExtraVariables::getByName($name);
			if ($extraVariable) {
				$extraVariable->value = $value;
				$extraVariable->update();
			}
		}
	}
	
	$notSave = array('saveChanges','favicon','logo','extra');
	
	$sql = 'update system_variables set ';
	$update = array();
	
	foreach ($_POST as $num => $value){
		if (!in_array($num, $notSave)) {
			$update[] = " $num = '$value' ";
		}
	}
	
	$sql .= implode(',', $update);
	$sql .= ' where system_variables_id = 1';
	echo $sql;
	$mysqli = ConnectionFactory::getFactory()->getConnection();
	$sql = $mysqli->prepare($sql);
	$sql->execute();
    $sql->close();
    
	header( "Location: variables.php?saved" );
	exit();
}
changeHeaderVariablesAdmin('', '', '', array());
function callback($buffer){}
?>
<div id="content-header" class="mini">
	<h1><?php echo $lang['SYSTEM_TITLE'] ?></h1>
	<div id="breadcrumb">
		<a href="index.php" title="<?php echo showLang($lang, 'HOME_BREADCRUM') ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, 'HOME_HOME') ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, 'SYSTEM_TITLE') ?></a>
	</div>	
</div>
<div class="container-fluid">
	<?php if (isset($_GET['saved'])){ ?>
	<div class="alert alert-success"><?php echo showLang($lang, 'SYSTEM_SAVED') ?></div>
	<?php } ?>
	<div class="row">
		<div class="col-xs-12">
			<form action="variables.php" method="post" class="form-horizontal">
				<!--  //////////  -->
				<div class="widget-box collapsible">
					<div class="widget-title">
						<a href="#collapse3" data-toggle="collapse">
							<span class="icon"><i class="fa fa-align-justify"></i></span>
							<h5><?php echo showLang($lang, 'SYSTEM_FRONT_TITLE') ?></h5>
						</a>
					</div>
					<div class="collapse" id="collapse3">
						<div class="widget-content">
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_PAGE_NAME') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="PAGE_NAME" value="<?php echo PAGE_NAME ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_CONTACT_EMAIL') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="CONTACT_EMAIL" value="<?php echo CONTACT_EMAIL ?>"></div>
							</div>
						</div>
					</div>
				</div>
				<!--  //////////  -->
				<div class="widget-box collapsible">
					<div class="widget-title">
						<a href="#collapse5" data-toggle="collapse">
							<span class="icon"><i class="fa fa-align-justify"></i></span>
							<h5><?php echo showLang($lang, 'SYSTEM_EMAIL_VARIABLES') ?></h5>
						</a>
					</div>
					<div class="collapse" id="collapse5">
						<div class="widget-content">
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_NO_REPLY_EMAIL') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="NO_REPLY_EMAIL" value="<?php echo NO_REPLY_EMAIL ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_NO_REPLY_NAME') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="extra[NO_REPLY_NAME]" value="<?php echo $extra['NO_REPLY_NAME'] ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_SMTP') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><?php echo showYesNo($extra['SMAIL_SMTP'], $lang, 'extra[SMAIL_SMTP]') ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_HOST') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="extra[SMAIL_HOST]" value="<?php echo $extra['SMAIL_HOST'] ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_PORT') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="extra[SMAIL_PORT]" value="<?php echo $extra['SMAIL_PORT'] ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_AUTH') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><?php echo showYesNo($extra['SMAIL_AUTH'], $lang, 'extra[SMAIL_AUTH]') ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_USERNAME') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="extra[SMAIL_USERNAME]" value="<?php echo $extra['SMAIL_USERNAME'] ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_PASSWORD') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10"><input class="form-control input-sm" name="extra[SMAIL_PASSWORD]" value="<?php echo $extra['SMAIL_PASSWORD'] ?>"></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, 'SYSTEM_SMAIL_DEBUG') ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10">
									<select class="form-control" name="extra[SMAIL_DEBUG]">
										<option value="0" <?php echo $extra['SMAIL_DEBUG'] == 0 ? 'selected' : '' ?>>SMTP::DEBUG_OFF</option>
										<option value="1" <?php echo $extra['SMAIL_DEBUG'] == 1 ? 'selected' : '' ?>>SMTP::DEBUG_CLIENT</option>
										<option value="2" <?php echo $extra['SMAIL_DEBUG'] == 2 ? 'selected' : '' ?>>SMTP::DEBUG_SERVER</option>
										<option value="3" <?php echo $extra['SMAIL_DEBUG'] == 3 ? 'selected' : '' ?>>SMTP::DEBUG_CONNECTION</option>
										<option value="4" <?php echo $extra['SMAIL_DEBUG'] == 4 ? 'selected' : '' ?>>SMTP::DEBUG_LOWLEVEL</option>
									</select>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--  //////////  -->
				<div class="form-actions">
					<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, 'SAVE_CHANGES') ?></button> 
					<a class="btn btn-primary btn-sm" href="variables.php"><?php echo showLang($lang, 'CANCEL_CHANGES') ?></a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php 
require_once dirname(__FILE__)."/footer.php";
?>