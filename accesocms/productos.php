<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

if (isset($_GET["rows"])) setAdminCookieValue("PRODS_PER_PAGE", $_GET["rows"]);
if (isset($_GET["rows"])){
	$url ="?"; foreach ($_GET as $n => $val){if ($n!="rows" && $n!="page") $url .= "$n=$val&";}
	header( "Location: productos.php".substr($url, 0, -1) );
	exit();
}

function callback($buffer){}

$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) {
	case "crop":
		cropImage($results);
		break;
	case "new":
	case "edit":
	    addEditProductoObject($results);
	    break;
	case "delete":
	    deleteProducto($results);
	    break;
    case "deleteAll":
	    deleteAllProducto($results);
	    break;
	default:
    	listProducto($results);
}

function cropImage($results) {
	$results["pageTitle"] = showLang($results["lang"], "CROP_IMAGE");
	if ( isset( $_POST["saveChanges"] ) ) {

	} elseif ( isset( $_POST["cancel"] ) ) {
		header( "Location: productos.php");
	} else {
		$image = Producto::getById( $_GET["id"] );
		if (isset($_GET["n"]) && $_GET["n"] == 5) {
            $results["x"] = 800;
			$results["y"] = 1000;
			$results["image"] = $image->foto;
			$results["imageUrl"] = IMAGES_PATH_HTML.$image->foto;
			$results["cropPath"] = IMAGES_PATH."crop".$_GET["n"]."/";
		}
		cropFotoImage($results);
	}
}

function addEditProductoObject($results) {
	$results["pageTitle"] = showLang($results["lang"], "PRODUCTO_NEW");
	$results["formAction"] = $_GET["action"];
  	if (isset( $_POST["saveChanges"])) {
    	$producto = new Producto( $_POST );
    	if ($producto->producto_id == "") $error = $producto->insert();
    	else $error = $producto->update();
    	if ($error["error"] == false){
	    	header( "Location: productos.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
	   }else{
	    	$results = returnProductoError($error["error"],$results);
	  		addEditProducto($results);
	    }
  	} else {
    	if ($_GET["action"] == "edit"){
			$producto = Producto::getById( $_GET["id"] );
			if (!$producto) $producto = new Producto();
			$results["producto"] = $producto;
		}else $results["producto"] = new Producto();
    	addEditProducto($results);
  	}
}

function returnProductoError($error,$results){
  	$results["error"] = $error;
  	$results["producto"] = new Producto( $_POST );
	return $results;
}

function deleteProducto() {
	if ( !$producto = Producto::getById(isset($_GET["id"]) ? $_GET["id"] : "")) {
		header( "Location: productos.php?error=productoNotFound" );
		exit();
	}
	$producto->delete();
	header( "Location: productos.php?status=productoDeleted" );
}

function deleteAllProducto() {
    Producto::deleteAll();
    header( "Location: productos.php?status=productoDeleted" );
    exit();
}

function listProducto($results) {
	$data = Producto::getAllList();
	if (isset($_POST["saveChanges"])){
		header( "Location: productos.php?status=changesSaved" );
		exit();
	}
	$results["all"] = $data["results"];
	$results["totalRows"] = $data["totalRows"];
	$results["pageTitle"] = $results["lang"]["PRODUCTO_LIST"];
	$results["pageTitle"] = showLang($results["lang"], "PRODUCTO_LIST");
	if ( isset( $_GET["error"] ) ) {
		if ( $_GET["error"] == "productoNotFound" ) $results["errorMessage"] = $results["lang"]["PRODUCTO_NOT_FOUND"];
	}
	if ( isset( $_GET["status"] ) ) {
		if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = $results["lang"]["SAVED_CHANGES"];
		if ( $_GET["status"] == "productoDeleted" ) $results["statusMessage"] = $results["lang"]["PRODUCTO_DELETED"];
	}
	listProductos($results);
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
				<input type="hidden" id="return" value="productos.php?status=changesSaved&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>">
				<img src="<?php echo $results["imageUrl"]."?rand=".rand() ?>" style="max-width: 100%" id="crop-img">
				<div class="text-center" style="margin: 20px 0px;">
					<button type="submit" class="btn btn-dark-green btn-sm" id="save" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
					<a class="btn btn-primary btn-sm" href="productos.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>cropImg();</script>
<?php }?>
<?php
// ----------------------------------- EDIT OR ADD PRODUCTO ----------------------------------- //
function addEditProducto($results){
	changeHeaderVariablesAdmin("", "", "", array());
	$lang = $results["lang"]; ?>
<div id="content-header" class="mini">
	<h1><?php echo showLang($lang, $results["pageTitle"]) ?></h1>
	<div id="breadcrumb">
		<a href="<?php echo ADMIN_PAGES_PATH_HTML ?>" title="<?php echo showLang($lang, "HOME_BREADCRUM") ?>" class="tip-bottom"><i class="fa fa-home"></i> <?php echo showLang($lang, "HOME_HOME") ?></a>
		<a href="productos.php" class="current"><?php echo showLang($lang,"HEADER_PRODUCTO") ?></a>
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
					<h5><?php echo showLang($lang, "PRODUCTO_INFO") ?></h5>
				</div>
				<div class="widget-content nopadding">
					<form action="productos.php?action=<?php echo $results["formAction"]?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>" method="post" class="form-horizontal validate-form" enctype="multipart/form-data">
						<div>
							<input class="form-control input-sm" type="hidden" name="producto_id" value='<?php echo $results["producto"]->producto_id ?>' />
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_NOMBRE") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10 titulo ">
								<input class="form-control input-sm" placeholder="<?php echo showLang($lang,"PRODUCTO_COL_NOMBRE") ?>" type="text" name="nombre" required  value='<?php echo $results["producto"]->nombre ?>' />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_PRECIO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="Valor en pesos" type="number" name="precio" required  value='<?php echo $results["producto"]->precio ?>' step="1"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_DESCUENTO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="Porcentaje" type="number" name="descuento" required  value='<?php echo $results["producto"]->precio ?>' step="1"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_FOTO") ?></label>
							<?php if($results["formAction"] != "edit"){ ?>
								<div class="col-sm-9 col-md-9 col-lg-10 form-control-static"><input type="file" name="foto" accept="image/*"/></div>
							<?php }else {
								list($url,$size) = returnThumbnailImage($results["producto"]->foto,PRODUCTOS_PATH_HTML,PRODUCTOS_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg');
								?>
								<div class="col-sm-9 col-md-9 col-lg-10 form-control-static">
									<img class="imageOnForm" src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>">
									<input type="hidden" name="foto" value="<?php echo $results["producto"]->foto ?>">
								</div>
							<?php } ?>
						</div>
						<?php if($results["formAction"] == "edit"){ ?>
							<div class="form-group">
								<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_FOTO") ?></label>
								<div class="col-sm-9 col-md-9 col-lg-10 form-control-static"><input type="file" name="foto2" accept="image/*"/></div>
							</div>
						<?php } ?>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_DURACION") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<input class="form-control input-sm" placeholder="Cantidad de horas" type="number" name="duracion" required  value='<?php echo $results["producto"]->duracion ?>' step="1"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_DESCRIPCION") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<textarea class="form-control" name="descripcion" ><?php echo $results["producto"]->descripcion ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_ELIMINADO") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<div class="checkbox">
									<label><input type="checkbox" name="destacada" value="1"  <?php echo $results["producto"]->eliminado ? "checked" : "" ?>  /></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo showLang($lang,"PRODUCTO_COL_CATEGORIAS") ?></label>
							<div class="col-sm-9 col-md-9 col-lg-10  ">
								<?php echo Categoria::getCategoriasMultiple('categorias', explode(',', $results["producto"]->categorias)) ?>
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
							<a class="btn btn-primary btn-sm" href="productos.php?page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
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
// ----------------------------------- LIST PRODUCTO ----------------------------------- //
function listProductos($results){
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
		<div class="row" id="dropable-images">
			<div class="col-xs-12">
				<a class="btn btn-sm btn-dark-green" href="productos.php?action=new"><?php echo showLang($lang,"PRODUCTO_ADD") ?></a>
				<div class="widget-box with-table">
					<div class="widget-content nopadding">
						<form action="productos.php" method="post">
							<table class="table table-bordered table-striped table-hover table-condensed ">
								<thead>
									<tr>
										<th width="40px"><input type="checkbox" id="select-all"></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_PRODUCTO_ID") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_VENDEDOR_ID") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_NOMBRE") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_PRECIO") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_DESCUENTO") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_FOTO") ?></th>
										<th><?php echo showLang($lang,"CROP") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_DURACION") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_DESCRIPCION") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_ELIMINADO") ?></th>
										<th><?php echo showLang($lang,"PRODUCTO_COL_CATEGORIAS") ?></th>
										<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $results["all"] as $num => $a ) { ?>
										<tr>
											<td align="center"><input type="checkbox" name="ids[]" value="<?php echo $a->producto_id ?>"></td>
											<td><?php echo $a->producto_id ?></td>
											<td><?php echo $a->vendedor_id ?></td>
											<td><?php echo $a->nombre ?></td>
											<td><?php echo $a->precio ?></td>
											<td><?php echo $a->descuento ?></td>
											<td>
												<?php list($url,$size) = returnThumbnailImage($a->foto,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
												<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
											</td>
											<td>
												<?php list($url,$size) = returnThumbnailImage($a->foto,IMAGES_PATH_HTML."crop/",IMAGES_PATH."crop/",100,100,"",""); ?>
												<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
												<br><a href="productos.php?action=crop&id=<?php echo $a->producto_id ?>&n=5"><?php echo showLang($lang, "CROP") ?></a>
											</td>
											<td><?php echo $a->duracion ?></td>
											<td><?php echo $a->descripcion ?></td>
											<td><?php echo $a->eliminado ?></td>
											<td>
												<?php list($url,$size) = returnThumbnailImage($a->categorias,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
												<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
											</td>
											<td align="center" width="100px">
												<a title="<?php echo showLang($lang, "TABLE_EDIT") ?>" class="tip-top edit" href="productos.php?action=edit&amp;id=<?php echo $a->producto_id ?>&page=<?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>"><i class="fa fa-pencil-alt"></i></a>
												<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" class="tip-top delete" data-txt="<?php echo showLang($lang, 'PRODUCTO_DELETE_CONFIRM') ?>" data-href="productos.php?action=delete&amp;ids=<?php echo $a->producto_id ?>">
													<i class="far fa-trash-alt"></i>
												</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<div class="pull-right">
								<button type="submit" class="btn btn-dark-green btn-sm" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
							</div>
							<div class="clearfix"></div>
							<a class="btn btn-sm btn-dark-green" href="productos.php?action=new"><?php echo showLang($lang,"PRODUCTO_ADD") ?></a>
							|
							<a class="btn btn-sm btn-danger delete-selected" data-href="productos.php?action=delete" data-txt="<?php echo showLang($lang,"DELETE_SELECTED_TXT") ?>"><?php echo showLang($lang,"DELETE_SELECTED") ?></a>
							<a class="btn btn-sm btn-danger delete-selected" data-href="productos.php?action=deleteAll" data-txt="<?php echo showLang($lang,"DELETE_ALL_TXT") ?>"><?php echo showLang($lang,"DELETE_ALL") ?></a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>multipleUpload("ajax/upload-image-producto.php")</script>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>
