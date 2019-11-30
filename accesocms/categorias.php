<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;
define ('SID', getVar('sid', 0));
function callback($buffer){}
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) {
	case "crop":
		cropImage($results);
		break;
	case "up":
		CategoriaUp($results);
		break;
	case "down":
		CategoriaDown($results);
		break;
	case "new":
	case "edit":
	    addEditCategoriaObject($results);
	    break;
	case "delete":
	    deleteCategoria($results);
	    break;
    case "deleteAll":
	    deleteAllCategoria($results);
	    break;
	default:
    	listCategoria($results);
}
function CategoriaUp($results){
	$order = $_GET["id"];
	if ($order > 1){
		Categoria::moveUp($order, SID);
	}
	header( "Location: categorias.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1)."&sid=".SID);
	exit();
}
function CategoriaDown($results){
	$order = $_GET["id"];
	Categoria::moveDown($order, SID);
	header( "Location: categorias.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1)."&sid=".SID);
	exit();
}
function cropImage($results) {
	$results["pageTitle"] = showLang($results["lang"], "CROP_IMAGE");
	if ( isset( $_POST["saveChanges"] ) ) {
	} elseif ( isset( $_POST["cancel"] ) ) {
		header( "Location: categorias.php");
	} else {
		$image = Categoria::getById( $_GET["id"] );
		if (isset($_GET["n"]) && $_GET["n"] == 3) {
            $results["x"] = 382;
			$results["y"] = 380;
			$results["image"] = $image->imagen;
			$results["imageUrl"] = IMAGES_PATH_HTML.$image->imagen;
			$results["cropPath"] = IMAGES_PATH."crop".$_GET["n"]."/";
		}
		cropFotoImage($results);
	}
}
function addEditCategoriaObject($results) {
	$results["pageTitle"] = showLang($results["lang"], "CATEGORIA_NEW");
	$results["formAction"] = $_GET["action"];
  	if (isset( $_POST["saveChanges"])) {
    	$categoria = new Categoria( $_POST );
		$categoria->subcategoria_id = SID;
    	if ($categoria->categoria_id == "") $error = $categoria->insert();
    	else $error = $categoria->update();
    	if ($error["error"] == false)
	    	header( "Location: categorias.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1)."&sid=".SID);
	    else{
	    	$results = returnCategoriaError($error["error"],$results);
	  		addEditCategoria($results);
	    }
  	} else {
    	if ($_GET["action"] == "edit"){
			$categoria = Categoria::getById( $_GET["id"] );
			if (!$categoria) $categoria = new Categoria();
			$results["categoria"] = $categoria;
		}else $results["categoria"] = new Categoria();
    	addEditCategoria($results);
  	}
}
function returnCategoriaError($error,$results){
  	$results["error"] = $error;
  	$results["categoria"] = new Categoria( $_POST );
	return $results;
}
function deleteCategoria() {
    $ids = isset($_GET["ids"]) ? explode(",", $_GET["ids"]) : array();
    foreach ($ids as $id) {
        $categoria = Categoria::getById($id);
        if ($categoria) $categoria->delete();
    }
	$categoria->delete();
	header( "Location: categorias.php?status=categoriaDeleted" ."&sid=".SID);
}
function deleteAllCategoria() {
    Categoria::deleteAll();
    header( "Location: categorias.php?status=categoriaDeleted" ."&sid=".SID);
    exit();
}
function listCategoria($results) {
	$data = Categoria::getAllListSubcategoria(SID);
	$results["all"] = $data["results"];
	$results["totalRows"] = $data["totalRows"];
	$results["pageTitle"] = showLang($results["lang"], "CATEGORIA_LIST");
	if ( isset( $_GET["error"] ) ) {
		if ( $_GET["error"] == "categoriaNotFound" ) $results["errorMessage"] = showLang($results["lang"], "CATEGORIA_NOT_FOUND");
	}
	if ( isset( $_GET["status"] ) ) {
		if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = showLang($results["lang"], "SAVED_CHANGES");
		if ( $_GET["status"] == "categoriaDeleted" ) $results["statusMessage"] = showLang($results["lang"], "CATEGORIA_DELETED");
	}
	listCategorias($results);
}
?>
<?php
// ----------------------------------- CROP IMAGE ----------------------------------- //
function cropFotoImage($results){
	changeHeaderVariablesAdmin("", "", "", array());
	$lang = $results["lang"];
	?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-1"></div>
		<div class="col-xs-10">
			<form action="ajax/crop-img.php">
				<input type="hidden" name="image" value="<?php echo $results["image"] ?>">
				<input type="hidden" name="cropPath" value="<?php echo $results["cropPath"] ?>">
				<input type="hidden" name="x" value="<?php echo $results["x"] ?>" id="x">
				<input type="hidden" name="y" value="<?php echo $results["y"] ?>" id="y">
				<input type="hidden" id="return" value="categorias.php?status=changesSaved&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>">
				<img src="<?php echo $results["imageUrl"]."?rand=".rand() ?>" style="max-width: 100%" id="crop-img">
				<div class="text-center" style="margin: 20px 0px;">
					<button type="submit" class="btn btn-dark-green btn-sm" id="save" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
					<a class="btn btn-primary btn-sm" href="categorias.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>cropImg();</script>
<?php }?>
<?php
// ----------------------------------- EDIT OR ADD CATEGORIA ----------------------------------- //
function addEditCategoria($results){
	changeHeaderVariablesAdmin("", "", "", array());
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="<?php echo ADMIN_PAGES_PATH_HTML ?>" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a>
		<a href="categorias.php" class="current"><?php echo showLang($lang,"HEADER_CATEGORIA") ?></a>
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
					<h5><?php echo showLang($lang, "CATEGORIA_INFO") ?></h5>
				</div>
				<div class="widget-content nopadding">
					<form action="categorias.php?action=<?php echo $results["formAction"]?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>&sid=<?php echo SID ?>" method="post" class="form-horizontal validate-form" enctype="multipart/form-data">
						<div>
							<input class="form-control input-sm" type="hidden" name="categoria_id" value='<?php echo $results["categoria"]->categoria_id ?>' />
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"CATEGORIA_COL_NOMBRE") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"CATEGORIA_COL_NOMBRE") ?>" type="text" name="nombre" required  value='<?php echo $results["categoria"]->nombre ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"CATEGORIA_COL_IMAGEN") ?></label>
						<?php if($results["formAction"] != "edit"){ ?>
							<div class="col-sm-9 col-md-9 col-lg-10 form-control-static"><input type="file" name="imagen" accept="image/*"/></div>
						<?php }else {
							list($url,$size) = returnThumbnailImage($results["categoria"]->imagen,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg');
						?>
							<div class="col-sm-9 col-md-9 col-lg-10 form-control-static">
								<img class="imageOnForm" src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>">
								<input type="hidden" name="imagen" value="<?php echo $results["categoria"]->imagen ?>">
							</div>
						<?php } ?>
						</div>
						<?php if($results["formAction"] == "edit"){ ?>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"CATEGORIA_COL_IMAGEN") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10 form-control-static"><input type="file" name="imagen2" accept="image/*"/></div>
						</div>
						<?php } ?>

						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"CATEGORIA_COL_DESTACADA") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<div class="checkbox">
									<label><input type="checkbox" name="destacada" value="1"  <?php echo $results["categoria"]->destacada ? "checked" : "" ?>  /></label>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
							<a class="btn btn-primary btn-sm" href="categorias.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>&sid=<?php echo SID ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<?php }?>

<?php
// ----------------------------------- LIST CATEGORIA ----------------------------------- //
function listCategorias($results){
	$back = SID == 0 ? null : Categoria::getById(SID);
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
			<a class="btn btn-sm btn-dark-green" href="categorias.php?action=new&sid=<?php echo SID ?>"><?php echo showLang($lang,"CATEGORIA_ADD") ?></a>
			<div class="widget-box with-table table-responsive">
				<div class="widget-content nopadding">
					<table class="table table-bordered table-striped table-hover table-condensed sortable-table ">
						<thead>
							<tr>
                        <th width="40px"><input type="checkbox" id="select-all"></th>
								<th width="40px" align="center"></th>
								<th width="40px" align="center"></th>
								<th><?php echo showLang($lang,"CATEGORIA_COL_NOMBRE") ?></th>
								<?php if (!$back){ ?><th>Subcategorias</th><?php } ?>
								<th><?php echo showLang($lang,"CATEGORIA_COL_IMAGEN") ?></th>
								<th><?php echo showLang($lang,"CROP") ?></th>
								<th><?php echo showLang($lang,"CATEGORIA_COL_DESTACADA") ?></th>
								<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ( $results["all"] as $num => $a ) { ?>
							<tr>
								<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $a->categoria_id ?>"></td>
								<td align="center"><i data-id="<?php echo $a->categoria_id ?>" class="fa fa-bars"></i></td>
								<td class="order-col">
									<a href="categorias.php?action=down&id=<?php echo $num+1 ?>&sid=<?php echo SID ?>" title="<?php echo showLang($lang, "TABLE_DOWN") ?>" class="tip-top set-down">
										<i class="fa fa-chevron-down"></i>
									</a>
									<a href="categorias.php?action=up&id=<?php echo $num+1 ?>&sid=<?php echo SID ?>" title="<?php echo showLang($lang, "TABLE_UP") ?>" class="tip-bottom set-up">
										<i class="fa fa-chevron-up"></i>
									</a>
								</td>
								<td><?php echo $a->nombre ?></td>
								<?php if (!$back){ ?><td><a href="categorias.php?sid=<?php echo $a->categoria_id ?>">Subcategorias</a></td><?php } ?>
								<td>
									<?php list($url,$size) = returnThumbnailImage($a->imagen,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
									<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
								</td>
								<td>
									<?php list($url,$size) = returnThumbnailImage($a->imagen,IMAGES_PATH_HTML."crop3/",IMAGES_PATH."crop3/",100,100,"",""); ?>
									<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
									<br><a href="categorias.php?action=crop&id=<?php echo $a->categoria_id ?>&n=3"><?php echo showLang($lang, "CROP") ?></a>
								</td>
								<td><i class="fas <?php echo $a->destacada ? 'fa-check text-success' : 'fa-times text-danger' ?> "></i></td>
								<td align="center" width="100px">
									<a title="<?php echo showLang($lang, "TABLE_EDIT") ?>" class="tip-top edit" href="categorias.php?action=edit&amp;id=<?php echo $a->categoria_id ?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>&sid=<?php echo SID ?>"><i class="fa fa-pencil-alt"></i></a>
									<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" data-txt="<?php echo showLang($lang, 'CATEGORIA_DELETE_CONFIRM') ?>" data-href="categorias.php?action=delete&amp;ids=<?php echo $a->categoria_id ?>&sid=<?php echo SID ?>">
										<i class="far fa-trash-alt"></i>
									</a>
								</td>
							</tr>
						<?php } ?>
			    		</tbody>
					</table>
				</div>
			</div>
			<?php if ($back){ ?>
			<a class="btn btn-primary btn-sm" href="categorias.php?sid=<?php echo $back->subcategoria_id ?>">Volver</a>
			<br>
			<?php } ?>
			<a class="btn btn-sm btn-dark-green" href="categorias.php?action=new&sid=<?php echo SID ?>"><?php echo showLang($lang,"CATEGORIA_ADD") ?></a>
            |
            <a class="btn btn-sm btn-danger delete-selected" data-href="categorias.php?action=delete&sid=<?php echo SID ?>" data-txt="<?php echo showLang($lang,"DELETE_SELECTED_TXT") ?>"><?php echo showLang($lang,"DELETE_SELECTED") ?></a>
		</div>
	</div>
</div>
<script>sortableTable("ajax/save-categoria.php")</script>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>
