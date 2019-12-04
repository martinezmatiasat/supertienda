<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;
if (!Producto::getById(getVar('pid'))){
	header('Location: productos.php');
	exit();
}
function callback($buffer){}
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) {
	case "crop":
		cropImage($results);
		break;
	case "up":
		ProductoImagenUp($results);
		break;
	case "down":
		ProductoImagenDown($results);
		break;
	case "delete":
	    deleteProductoImagen($results);
	    break;
	default:
    	listProductoImagen($results);
}
function ProductoImagenUp($results){
	$order = $_GET["id"];
	if ($order > 1){
		ProductoImagen::moveUp($order, getVar('pid'));
	}
	header( "Location: productoImagenes.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1)."&pid=".getVar('pid'));
	exit();
}
function ProductoImagenDown($results){
	$order = $_GET["id"];
	ProductoImagen::moveDown($order, getVar('pid'));
	header( "Location: productoImagenes.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1)."&pid=".getVar('pid'));
	exit();
}
function cropImage($results) {
	$results["pageTitle"] = showLang($results["lang"], "CROP_IMAGE");
	if ( isset( $_POST["saveChanges"] ) ) {
	} elseif ( isset( $_POST["cancel"] ) ) {
		header( "Location: productoImagenes.php");
	} else {
		$image = ProductoImagen::getById( $_GET["id"] );
		if (isset($_GET["n"]) && $_GET["n"] == 2) {
            $results["x"] = 800;
			$results["y"] = 900;
			$results["image"] = $image->imagen;
			$results["imageUrl"] = PRODUCTOS_PATH_HTML.$image->imagen;
			$results["cropPath"] = PRODUCTOS_PATH."crop".$_GET["n"]."/";
		}
		cropFotoImage($results);
	}
}
function deleteProductoImagen() {
	if ( !$producto_imagen = ProductoImagen::getById(isset($_GET["id"]) ? $_GET["id"] : "")) {
		header( "Location: productoImagenes.php?error=producto_imagenNotFound"."&pid=".getVar('pid'));
		exit();
	}
	$producto_imagen->delete();
	header( "Location: productoImagenes.php?status=producto_imagenDeleted"."&pid=".getVar('pid'));
}
function listProductoImagen($results) {
	$data = ProductoImagen::getAllList(getVar('pid'));
	$results["all"] = $data["results"];
	$results["totalRows"] = $data["totalRows"];
	$results["pageTitle"] = $results["lang"]["PRODUCTO_IMAGEN_LIST"];
	if ( isset( $_GET["error"] ) ) {
		if ( $_GET["error"] == "producto_imagenNotFound" ) $results["errorMessage"] = $results["lang"]["PRODUCTO_IMAGEN_NOT_FOUND"];
	}
	if ( isset( $_GET["status"] ) ) {
		if ( $_GET["status"] == "changesSaved" ) $results["statusMessage"] = $results["lang"]["SAVED_CHANGES"];
		if ( $_GET["status"] == "producto_imagenDeleted" ) $results["statusMessage"] = $results["lang"]["PRODUCTO_IMAGEN_DELETED"];
	}
	listProductoImagens($results);
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
				<input type="hidden" id="return" value="productoImagenes.php?status=changesSaved&pid=<?php echo getVar('pid') ?>">
				<img src="<?php echo $results["imageUrl"]."?rand=".rand() ?>" style="max-width: 100%" id="crop-img">
				<div class="text-center" style="margin: 20px 0px;">
					<button type="submit" class="btn btn-dark-green btn-sm" id="save" name="saveChanges"><?php echo showLang($lang, "SAVE_CHANGES") ?></button>
					<a class="btn btn-primary btn-sm" href="productoImagenes.php?pid=<?php echo getVar('pid') ?>"><?php echo showLang($lang, "CANCEL_CHANGES") ?></a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>cropImg();</script>
<?php }?>
<?php
// ----------------------------------- LIST PRODUCTO_IMAGEN ----------------------------------- //
function listProductoImagens($results){
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
			<div class="widget-box">
				<div class="widget-content">
					<?php echo showLang($lang, "DRAG_DROP_INFO") ?><br>
					<input id="fileToUpload" type="file" size="45" name="fileToUpload[]" class="input" accept="image/*" multiple>
				</div>
			</div>
			<div class="widget-box with-table">
				<div class="widget-content nopadding">
					<form action="productoImagenes.php" method="post">
						<table class="table table-bordered table-striped table-hover table-condensed sortable-table">
							<thead>
								<tr>
									<th width="40px" align="center"></th>
									<th width="40px" align="center"></th>
									<th><?php echo showLang($lang,"PRODUCTO_IMAGEN_COL_IMAGEN") ?></th>
									<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ( $results["all"] as $num => $a ) { ?>
								<tr>
									<td align="center"><i data-id="<?php echo $a->producto_imagen_id ?>" class="fa fa-bars"></i></td>
									<td class="order-col">
										<a href="productoImagenes.php?action=down&id=<?php echo $num+1 ?>&pid=<?php echo getVar('pid') ?>" title="<?php echo showLang($lang, "TABLE_DOWN") ?>" class="tip-top set-down">
											<i class="fa fa-chevron-down"></i>
										</a>
										<a href="productoImagenes.php?action=up&id=<?php echo $num+1 ?>&pid=<?php echo getVar('pid') ?>" title="<?php echo showLang($lang, "TABLE_UP") ?>" class="tip-bottom set-up">
											<i class="fa fa-chevron-up"></i>
										</a>
									</td>
									<td>
										<?php list($url,$size) = returnThumbnailImage($a->imagen,PRODUCTOS_PATH_HTML,PRODUCTOS_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
										<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
									</td>
									<td align="center" width="100px">
					        			<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" href="javascript:if(confirm('<?php echo $lang['PRODUCTO_IMAGEN_DELETE_CONFIRM'] ?>')) location.href = 'productoImagenes.php?action=delete&amp;id=<?php echo $a->producto_imagen_id ?>&pid=<?php echo getVar('pid') ?>'">
					          			<i class="far fa-trash-alt"></i>
					          		</a>
			          			</td>
								</tr>
							<?php } ?>
			    			</tbody>
						</table>
					</form>
				</div>
			</div>
			<a class="btn btn-primary btn-sm" href="productos.php">Volver</a>
		</div>
	</div>
</div>
<script>multipleUpload("ajax/upload-image-producto_imagen.php?pid=<?php echo getVar('pid') ?>")</script>
<script>sortableTable("ajax/save-producto_imagen.php")</script>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>
