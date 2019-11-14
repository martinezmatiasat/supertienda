<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

function callback($buffer){}

	$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
	switch ( $action ) {
		case "new":
		case "edit":
		addEditVendedorObject($results);
		break;
		case "delete":
		deleteVendedor($results);
		break;
		case "deleteAll":
		deleteAllVendedor($results);
		break;
		default:
		listVendedor($results);
	}

	function addEditVendedorObject($results) {
		$results["pageTitle"] = showLang($results["lang"], "VENDEDOR_NEW");
		$results["formAction"] = $_GET["action"];
		if (isset( $_POST["saveChanges"])) {
			$vendedor = new Vendedor( $_POST );
			if ($vendedor->vendedor_id == "") $error = $vendedor->insert();
			else $error = $vendedor->update();
			if ($error["error"] == false){

				// GENERO EL USUARIO
				$vendedor = Vendedor::getById($error['id']);
				if ($vendedor->u1_id == 0){
					$u1 = new U1(array("usuario" => $vendedor->mail, "clave" => getVar("clave"), "email" => $vendedor->mail, "rol" => 1));
					$u1Error = $u1->insert();
					$vendedor->u1_id = $u1Error['id'];
					$vendedor->updateFields(array("u1_id"));
				}else {
					$u1 = U1::getByUsuario($vendedor->mail);
					if ($u1){
						$u1->usuario = $vendedor->mail;
						$u1->email = $vendedor->mail;
						$u1->updateFields(array("usuario","email"));
						if (isset($_POST['clave']) && $_POST['clave'] != ''){
							$u1->clave = sha1($_POST['clave']);
							$u1->updateFields(array("clave"));
						}
					}else {
						$u1 = new U1(array("usuario" => $vendedor->mail, "clave" => getVar("clave"), "email" => $vendedor->mail, "rol" => 1));
						$u1Error = $u1->insert();
						$vendedor->u1_id = $u1Error['id'];
						$vendedor->updateFields(array("u1_id"));
					}
				}
				
				header( "Location: vendedores.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
			}else{
				$results = returnVendedorError($error["error"],$results);
				addEditVendedor($results);
			}
		} else {
			if ($_GET["action"] == "edit"){
				$vendedor = Vendedor::getById( $_GET["id"] );
				if (!$vendedor) $vendedor = new Vendedor();
				$results["vendedor"] = $vendedor;
			}else $results["vendedor"] = new Vendedor();
			addEditVendedor($results);
		}
	}

	function returnVendedorError($error,$results){
		$results["error"] = $error;
		$results["vendedor"] = new Vendedor( $_POST );
		return $results;
	}

	function deleteVendedor() {
		$ids = isset($_GET["ids"]) ? explode(",", $_GET["ids"]) : array();
		foreach ($ids as $id) {
			$vendedor = Vendedor::getById($id);
			if ($vendedor) $vendedor->delete();
		}
		$vendedor->delete();
		header( "Location: vendedores.php?status=vendedorDeleted" );
	}

	function deleteAllVendedor() {
		Vendedor::deleteAll();
		header( "Location: vendedores.php?status=vendedorDeleted" );
		exit();
	}

	function listVendedor($results) {
		$data = Vendedor::getAllList();
		$results["all"] = $data["results"];
		$results["totalRows"] = $data["totalRows"];
		$results["pageTitle"] = showLang($results["lang"], "VENDEDOR_LIST");
		if ( isset( $_GET["error"] ) ) {
			if ( $_GET["error"] == "vendedorNotFound" ) $results["errorMessage"] = showLang($results["lang"], "VENDEDOR_NOT_FOUND");
		}
		if ( isset( $_GET["status"] ) ) {
			if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = showLang($results["lang"], "SAVED_CHANGES");
			if ( $_GET["status"] == "vendedorDeleted" ) $results["statusMessage"] = showLang($results["lang"], "VENDEDOR_DELETED");
		}
		listVendedors($results);
	}

	// ----------------------------------- EDIT OR ADD VENDEDOR ----------------------------------- //
	function addEditVendedor($results){
		changeHeaderVariablesAdmin("", "", "", array());
		$lang = $results["lang"]; ?>
		<div id="content-header" class="mini">
			<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
			<div id="breadcrumb">
				<a href="<?php echo ADMIN_PAGES_PATH_HTML ?>" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a>
				<a href="vendedores.php" class="current"><?php echo showLang($lang,"HEADER_VENDEDOR") ?></a>
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
							<h5><?php echo showLang($lang, "VENDEDOR_INFO") ?></h5>
						</div>
						<div class="widget-content nopadding">
							<form action="vendedores.php?action=<?php echo $results["formAction"]?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>" method="post" class="form-horizontal validate-form" enctype="multipart/form-data">
								<div>
									<input class="form-control input-sm" type="hidden" name="vendedor_id" value='<?php echo $results["vendedor"]->vendedor_id ?>' />
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_NOMBRE") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_NOMBRE") ?>" type="text" name="nombre" value='<?php echo $results["vendedor"]->nombre ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_APELLIDO") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_APELLIDO") ?>" type="text" name="apellido" value='<?php echo $results["vendedor"]->apellido ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_NOMBRE_TIENDA") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10 titulo ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_NOMBRE_TIENDA") ?>" type="text" name="nombre_tienda" required  value='<?php echo $results["vendedor"]->nombre_tienda ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_URL") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  url">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_URL") ?>" type="text" name="url" required  value='<?php echo $results["vendedor"]->url ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_DIRECCION") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_DIRECCION") ?>" type="text" name="direccion" value='<?php echo $results["vendedor"]->direccion ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_TELEFONO") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_TELEFONO") ?>" type="text" name="telefono" value='<?php echo $results["vendedor"]->telefono ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_MAIL") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_MAIL") ?>" type="text" name="mail" value='<?php echo $results["vendedor"]->mail ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"VENDEDOR_COL_U1_ID") ?></label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"VENDEDOR_COL_U1_ID") ?>" type="text" name="u1_id" value='<?php echo $results["vendedor"]->u1_id ?>' />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-3 col-lg-2 control-label">Clave</label>
									<div class="col-sm-9 col-md-9 col-lg-10  ">
										<input class="form-control input-sm" placeholder="Clave" type="password" name="clave" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
									<a class="btn btn-primary btn-sm" href="vendedores.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<script>getTitle('.titulo input', '.url input');</script>
		</div>
	<?php }?>

	<?php
	// ----------------------------------- LIST VENDEDOR ----------------------------------- //
	function listVendedors($results){
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
					<a class="btn btn-sm btn-dark-green" href="vendedores.php?action=new"><?php echo showLang($lang,"VENDEDOR_ADD") ?></a>
					<div class="widget-box with-table table-responsive">
						<div class="widget-content nopadding">
							<table class="table table-bordered table-striped table-hover table-condensed  ">
								<thead>
									<tr>
										<th width="40px"><input type="checkbox" id="select-all"></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_VENDEDOR_ID") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_NOMBRE") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_APELLIDO") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_NOMBRE_TIENDA") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_URL") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_DIRECCION") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_TELEFONO") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_MAIL") ?></th>
										<th><?php echo showLang($lang,"VENDEDOR_COL_U1_ID") ?></th>
										<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $results["all"] as $num => $a ) { ?>
										<tr>
											<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $a->vendedor_id ?>"></td>
											<td><?php echo $a->vendedor_id ?></td>
											<td><?php echo $a->nombre ?></td>
											<td><?php echo $a->apellido ?></td>
											<td><?php echo $a->nombre_tienda ?></td>
											<td><?php echo $a->url ?></td>
											<td><?php echo $a->direccion ?></td>
											<td><?php echo $a->telefono ?></td>
											<td><?php echo $a->mail ?></td>
											<td><?php echo $a->u1_id ?></td>
											<td align="center" width="100px">
												<a title="<?php echo showLang($lang, "TABLE_EDIT") ?>" class="tip-top edit" href="vendedores.php?action=edit&amp;id=<?php echo $a->vendedor_id ?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><i class="fa fa-pencil-alt"></i></a>
												<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" data-txt="<?php echo showLang($lang, 'VENDEDOR_DELETE_CONFIRM') ?>" data-href="vendedores.php?action=delete&amp;ids=<?php echo $a->vendedor_id ?>">
													<i class="far fa-trash-alt"></i>
												</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<a class="btn btn-sm btn-dark-green" href="vendedores.php?action=new"><?php echo showLang($lang,"VENDEDOR_ADD") ?></a>
					|
					<a class="btn btn-sm btn-danger delete-selected" data-href="vendedores.php?action=delete" data-txt="<?php echo showLang($lang,"DELETE_SELECTED_TXT") ?>"><?php echo showLang($lang,"DELETE_SELECTED") ?></a>
					<a class="btn btn-sm btn-danger delete" data-href="vendedores.php?action=deleteAll" data-txt="<?php echo showLang($lang,"DELETE_ALL_TXT") ?>"><?php echo showLang($lang,"DELETE_ALL") ?></a>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php require dirname(__FILE__)."/footer.php"; ?>
