<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

function callback($buffer){}
			
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) { 
	case "new":
	case "edit":
	    addEditCompraObject($results);
	    break;
	case "delete":
	    deleteCompra($results);
	    break;
    case "deleteAll":
	    deleteAllCompra($results);
	    break;
	default:
    	listCompra($results);
}

function addEditCompraObject($results) {
	$results["pageTitle"] = showLang($results["lang"], "COMPRA_NEW");
	$results["formAction"] = $_GET["action"];
  	if (isset( $_POST["saveChanges"])) {
    	$compra = new Compra( $_POST );
    	if ($compra->compra_id == "") $error = $compra->insert();
    	else $error = $compra->update();
    	if ($error["error"] == false)
	    	header( "Location: compras.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
	    else{
	    	$results = returnCompraError($error["error"],$results);
	  		addEditCompra($results);
	    }
  	} else {
    	if ($_GET["action"] == "edit"){
			$compra = Compra::getById( $_GET["id"] );
			if (!$compra) $compra = new Compra();
			$results["compra"] = $compra;
		}else $results["compra"] = new Compra();
    	addEditCompra($results);
  	}
}

function returnCompraError($error,$results){
  	$results["error"] = $error;
  	$results["compra"] = new Compra( $_POST );
	return $results;
}

function deleteCompra() {
    $ids = isset($_GET["ids"]) ? explode(",", $_GET["ids"]) : array();
    foreach ($ids as $id) {
        $compra = Compra::getById($id);
        if ($compra) $compra->delete();
    }
	$compra->delete();
	header( "Location: compras.php?status=compraDeleted" );
}

function deleteAllCompra() {
    Compra::deleteAll();
    header( "Location: compras.php?status=compraDeleted" );
    exit();
}

function listCompra($results) {
	$data = Compra::getAllList();
	$results["all"] = $data["results"];
	$results["totalRows"] = $data["totalRows"];
	$results["pageTitle"] = showLang($results["lang"], "COMPRA_LIST");
	if ( isset( $_GET["error"] ) ) {
		if ( $_GET["error"] == "compraNotFound" ) $results["errorMessage"] = showLang($results["lang"], "COMPRA_NOT_FOUND");
	}
	if ( isset( $_GET["status"] ) ) {
		if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = showLang($results["lang"], "SAVED_CHANGES");
		if ( $_GET["status"] == "compraDeleted" ) $results["statusMessage"] = showLang($results["lang"], "COMPRA_DELETED");
	}
	listCompras($results);
}
?>
<?php
// ----------------------------------- EDIT OR ADD COMPRA ----------------------------------- //
function addEditCompra($results){
	changeHeaderVariablesAdmin("", "", "", array());
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="<?php echo ADMIN_PAGES_PATH_HTML ?>" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a> 
		<a href="compras.php" class="current"><?php echo showLang($lang,"HEADER_COMPRA") ?></a>
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
					<h5><?php echo showLang($lang, "COMPRA_INFO") ?></h5>
				</div>
				<div class="widget-content nopadding">
					<form action="compras.php?action=<?php echo $results["formAction"]?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>" method="post" class="form-horizontal validate-form" enctype="multipart/form-data">
						<div>
							<input class="form-control input-sm" type="hidden" name="compra_id" value='<?php echo $results["compra"]->compra_id ?>' />
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_PRODUCTO_ID") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_PRODUCTO_ID") ?>" type="text" name="producto_id" value='<?php echo $results["compra"]->producto_id ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_VENDEDOR_ID") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_VENDEDOR_ID") ?>" type="text" name="vendedor_id" value='<?php echo $results["compra"]->vendedor_id ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_CODIGO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_CODIGO") ?>" type="text" name="codigo" value='<?php echo $results["compra"]->codigo ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_EMAIL") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_EMAIL") ?>" type="text" name="email" value='<?php echo $results["compra"]->email ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_ESTADO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_ESTADO") ?>" type="text" name="estado" value='<?php echo $results["compra"]->estado ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_SESSION_ID") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_SESSION_ID") ?>" type="text" name="session_id" value='<?php echo $results["compra"]->session_id ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"COMPRA_COL_FECHA_EXPIRACION") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"COMPRA_COL_FECHA_EXPIRACION") ?>" type="text" name="fecha_expiracion" value='<?php echo $results["compra"]->fecha_expiracion ?>' />
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button> 
							<a class="btn btn-primary btn-sm" href="compras.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
</div>
<?php }?>

<?php
// ----------------------------------- LIST COMPRA ----------------------------------- //
function listCompras($results){
	changeHeaderVariablesAdmin("", "", "", array()); 
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="<?php echo ADMIN_PAGES_PATH_HTML ?>" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a> 
		<a href="#" class="current"><?php echo showLang($lang, $results["pageTitle"]) ?></a>
	</div>	
</div>
<div class="container-fluid">
	<?php if ( isset( $results["errorMessage"] ) ) { ?><div class="alert alert-danger"><?php echo $results["errorMessage"] ?></div><?php } ?>
	<?php if ( isset( $results["statusMessage"] ) ) { ?><div class="alert alert-success"><?php echo $results["statusMessage"] ?></div><?php } ?>
	<div class="row">
		<div class="col-xs-12">
			<a class="btn btn-sm btn-dark-green" href="compras.php?action=new"><?php echo showLang($lang,"COMPRA_ADD") ?></a>
			<div class="widget-box with-table table-responsive">
				<div class="widget-content nopadding">
					<table class="table table-bordered table-striped table-hover table-condensed  data-table">
						<thead>
							<tr>
                                <th width="40px"><input type="checkbox" id="select-all"></th>
								<th><?php echo showLang($lang,"COMPRA_COL_COMPRA_ID") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_PRODUCTO_ID") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_VENDEDOR_ID") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_CODIGO") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_EMAIL") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_ESTADO") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_SESSION_ID") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_FECHA_EXPIRACION") ?></th>
								<th><?php echo showLang($lang,"COMPRA_COL_FECHA_COMPRA") ?></th>
								<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $results["all"] as $num => $a ) { ?>
							<tr>
                                <td align="center"><input type="checkbox" name="ids[]" value="<?php echo $a->compra_id ?>"></td>
								<td><?php echo $a->compra_id ?></td>
								<td><?php echo $a->producto_id ?></td>
								<td><?php echo $a->vendedor_id ?></td>
								<td><?php echo $a->codigo ?></td>
								<td><?php echo $a->email ?></td>
								<td><?php echo $a->estado ?></td>
								<td><?php echo $a->session_id ?></td>
								<td><?php echo $a->fecha_expiracion ?></td>
								<td><?php echo $a->fecha_compra ?></td>
								<td align="center" width="100px">
					        		<a title="<?php echo showLang($lang, "TABLE_EDIT") ?>" class="tip-top edit" href="compras.php?action=edit&amp;id=<?php echo $a->compra_id ?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><i class="fa fa-pencil-alt"></i></a>
					          		<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" data-txt="<?php echo showLang($lang, 'COMPRA_DELETE_CONFIRM') ?>" data-href="compras.php?action=delete&amp;ids=<?php echo $a->compra_id ?>">
					          			<i class="far fa-trash-alt"></i>
					          		</a>
			          			</td>
							</tr>
						<?php } ?>
			    		</tbody>
					</table>
				</div>
			</div>		
			<a class="btn btn-sm btn-dark-green" href="compras.php?action=new"><?php echo showLang($lang,"COMPRA_ADD") ?></a>
            |
            <a class="btn btn-sm btn-danger delete-selected" data-href="compras.php?action=delete" data-txt="<?php echo showLang($lang,"DELETE_SELECTED_TXT") ?>"><?php echo showLang($lang,"DELETE_SELECTED") ?></a>
			<a class="btn btn-sm btn-danger delete" data-href="compras.php?action=deleteAll" data-txt="<?php echo showLang($lang,"DELETE_ALL_TXT") ?>"><?php echo showLang($lang,"DELETE_ALL") ?></a>
		</div>
	</div>
</div>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>