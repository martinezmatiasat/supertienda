<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

if (isset($_GET["rows"])) setAdminCookieValue("ADMINS_PER_PAGE", $_GET["rows"]);
if (isset($_GET["rows"])){
	$url ="?"; foreach ($_GET as $n => $val){if ($n!="rows" && $n!="page") $url .= "$n=$val&";}
	header( "Location: administradores.php".substr($url, 0, -1) );
	exit();
}

function callback($buffer){}
			
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) { 
	case "new":
	case "edit":
	    addEditU1Object($results);
	    break;
	case "delete":
	    deleteU1($results);
	    break;
	default:
    	listU1($results);
}

function addEditU1Object($results) {
	$results["pageTitle"] = showLang($results["lang"], "U1_NEW");
	$results["formAction"] = $_GET["action"];
  	if (isset( $_POST["saveChanges"])) {
    	$u1 = new U1( $_POST );
    	if ($u1->u1_id == "") $error = $u1->insert();
    	else $error = $u1->update();
    	if ($error["error"] == false){
    		if ($u1->u1_id != '' && isset($_POST['clave']) && $_POST['clave'] != ''){
    			$u1->clave = sha1($_POST['clave']);
    			$u1->updateFields(array("clave"));
    		}    		
	    	header( "Location: administradores.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
    	}else{
	    	$results = returnU1Error($error["error"],$results);
	  		addEditU1($results);
	    }
  	} else {
    	if ($_GET["action"] == "edit"){
			$u1 = U1::getById( $_GET["id"] );
			if (!$u1) $u1 = new U1();
			$results["u1"] = $u1;
		}else $results["u1"] = new U1();
    	addEditU1($results);
  	}
}

function returnU1Error($error,$results){
  	$results["error"] = $error;
  	$results["u1"] = new U1( $_POST );
	return $results;
}

function deleteU1() {
	if ( !$u1 = U1::getById(isset($_GET["id"]) ? $_GET["id"] : "")) {
		header( "Location: administradores.php?error=u1NotFound" );
		exit();
	}
	$u1->delete();
	header( "Location: administradores.php?status=u1Deleted" );
}

function listU1($results) {
	$page = (isset($_GET["page"])) ? (int)($_GET["page"]) : 1;
	$data = U1::getList($page);
	$results["all"] = $data["results"];
	$results["totalRows"] = $data["totalRows"];
	$results["pageTitle"] = showLang($results["lang"], "U1_LIST");
	if ( isset( $_GET["error"] ) ) {
		if ( $_GET["error"] == "u1NotFound" ) $results["errorMessage"] = $results["lang"]["U1_NOT_FOUND"];
	}
	if ( isset( $_GET["status"] ) ) {
		if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = $results["lang"]["SAVED_CHANGES"];
		if ( $_GET["status"] == "u1Deleted" ) $results["statusMessage"] = $results["lang"]["U1_DELETED"];
	}
	listU1s($results);
}
?>
<?php
// ----------------------------------- EDIT OR ADD U1 ----------------------------------- //
function addEditU1($results){
	changeHeaderVariablesAdmin("", "", "", array());
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="#" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a> 
		<a href="administradores.php" class="current"><?php echo showLang($lang,"HEADER_U1") ?></a>
		<a href="#" class="current"><?php echo showLang($lang, $results["pageTitle"]) ?></a>
	</div>	
</div>
<div class="container-fluid">
	<?php if (isset($results["error"])){ ?>
	<div class="alert alert-danger"><ul><?php foreach ($results["error"] as $e) echo "<li>".showLang($lang, $e)."</li>" ?></ul></div>
	<?php } ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon"><i class="fa fa-align-justify"></i></span>
					<h5><?php echo showLang($lang, "U1_INFO") ?></h5>
				</div>
				<div class="widget-content nopadding">
					<form action="administradores.php?action=<?php echo $results["formAction"]?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>" method="post" class="form-horizontal validate-form" enctype="multipart/form-data" autocomplete="off">
						<input class="form-control input-sm" type="hidden" name="u1_id" value='<?php echo $results["u1"]->u1_id ?>' />
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"U1_COL_USUARIO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"U1_COL_USUARIO") ?>" type="text" name="usuario" required  value='<?php echo $results["u1"]->usuario ?>' autocomplete="new-password"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang, $results["formAction"] == 'edit' ? 'U1_COL_CLAVE' : 'U1_COL_CLAVE_CAMBIAR') ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"U1_COL_CLAVE") ?>" type="password" name="clave" <?php echo $results["formAction"] != 'edit' ? 'required' : '' ?> autocomplete="new-password"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"U1_COL_EMAIL") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"U1_COL_EMAIL") ?>" type="email" name="email" required  value='<?php echo $results["u1"]->email ?>' />
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button> 
							<a class="btn btn-primary btn-sm" href="administradores.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>

<?php
// ----------------------------------- LIST U1 ----------------------------------- //
function listU1s($results){
	changeHeaderVariablesAdmin("", "", "", array()); 
$rows = getAdminCookieValue("ADMINS_PER_PAGE");
	if (!$rows || !ctype_digit($rows)) $rows = DEFAULT_ROWS;
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="#" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, $results["pageTitle"]) ?></a>
	</div>	
</div>
<div class="container-fluid">
	<?php if ( isset( $results["errorMessage"] ) ) { ?><div class="alert alert-danger"><?php echo $results["errorMessage"] ?></div><?php } ?>
	<?php if ( isset( $results["statusMessage"] ) ) { ?><div class="alert alert-success"><?php echo $results["statusMessage"] ?></div><?php } ?>
	<div class="row">
		<div class="col-xs-12">
			<a class="btn btn-dark-green" href="administradores.php?action=new"><?php echo showLang($lang,"U1_ADD") ?></a>
			<div class="tableSettings">
				<span><?php echo $lang["TABLE_ROWS"] ?></span>
				<?php echo rowsPerPageSelect($rows); ?>
			</div>
			<div class="widget-box with-table table-responsive">
				<div class="widget-content nopadding">
					<table class="table table-bordered table-striped table-hover table-condensed ">
						<thead>
							<tr>
								<th><?php echo showLang($lang,"U1_COL_USUARIO") ?></th>
								<th><?php echo showLang($lang,"U1_COL_EMAIL") ?></th>
								<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $results["all"] as $num => $a ) { ?>
							<tr>
								<td><?php echo $a->usuario ?></td>
								<td><?php echo $a->email ?></td>
								<td align="center" width="100px">
					        		<a title="<?php echo showLang($lang, "TABLE_EDIT") ?>" class="tip-top edit" href="administradores.php?action=edit&amp;id=<?php echo $a->u1_id ?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><i class="fa fa-pencil-alt"></i></a>
					          		<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" data-txt="<?php echo showLang($lang, 'U1_DELETE_CONFIRM') ?>" data-href="administradores.php?action=delete&amp;id=<?php echo $a->u1_id ?>'">
					          			<i class="far fa-trash-alt"></i>
					          		</a>
			          			</td>
							</tr>
						<?php } ?>
			    		</tbody>
					</table>
				</div>
			</div>
			<div id="pagination">
				<ul class="pagination alternate">
					<?php $url ="?"; foreach ($_GET as $n => $val){if ($n!="page") $url .= "$n=$val&";} ?>
					<?php showAdminPagination($rows,$results["totalRows"],$url,isset($_GET["page"]) ? $_GET["page"] : "1", $lang); ?>
				</ul>
			</div>
			<script>rowsPerPage();</script>		
			<a class="btn btn-dark-green" href="administradores.php?action=new"><?php echo showLang($lang,"U1_ADD") ?></a>
		</div>
	</div>
</div>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>