<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

function callback($buffer){}
		
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) { 	
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
		ProductoImagen::moveUp($order);
	}
	header( "Location: producto_imagenes.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
	exit();
}

function ProductoImagenDown($results){
	$order = $_GET["id"];
	ProductoImagen::moveDown($order);
	header( "Location: producto_imagenes.php?status=changesSaved&page=".(isset($_GET["page"]) ? $_GET["page"] : 1));
	exit();
}

function deleteProductoImagen() {
	if ( !$producto_imagen = ProductoImagen::getById(isset($_GET["id"]) ? $_GET["id"] : "")) {
		header( "Location: producto_imagenes.php?error=producto_imagenNotFound" );
		exit();
	}
	$producto_imagen->delete();
	header( "Location: producto_imagenes.php?status=producto_imagenDeleted" );
}

function listProductoImagen($results) {
	$data = ProductoImagen::getAllList();
	if (isset($_POST["saveChanges"])){
		header( "Location: producto_imagenes.php?status=changesSaved" );
		exit();
	}
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
					<form action="producto_imagenes.php" method="post">
						<table class="table table-bordered table-striped table-hover table-condensed sortable-table">
							<thead>
								<tr>
									<th width="40px" align="center"></th>
									<th width="40px" align="center"></th>
									<th><?php echo showLang($lang,"PRODUCTO_IMAGEN_COL_PRODUCTO_IMAGEN_ID") ?></th>
									<th><?php echo showLang($lang,"PRODUCTO_IMAGEN_COL_PRODUCTO_ID") ?></th>
									<th><?php echo showLang($lang,"PRODUCTO_IMAGEN_COL_IMAGEN") ?></th>
									<th><?php echo showLang($lang,"PRODUCTO_IMAGEN_COL_ORDEN") ?></th>
									<th><?php echo showLang($lang, "TABLE_ACTIONS") ?></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ( $results["all"] as $num => $a ) { ?>
								<tr>
									<td align="center"><i data-id="<?php echo $a->producto_imagen_id ?>" class="fa fa-bars"></i></td>
									<td class="order-col">
										<a href="producto_imagenes.php?action=down&id=<?php echo $num+1 ?>"title="<?php echo showLang($lang, "TABLE_DOWN") ?>" class="tip-top set-down">
											<i class="fa fa-chevron-down"></i>
										</a>
										<a href="producto_imagenes.php?action=up&id=<?php echo $num+1 ?>" title="<?php echo showLang($lang, "TABLE_UP") ?>" class="tip-bottom set-up">
											<i class="fa fa-chevron-up"></i>
										</a>
									</td>
									<td><input type="text" class="form-control" value="<?php echo $a->producto_imagen_id ?>" name="producto_imagen_id[<?php echo $a->producto_imagen_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->producto_id ?>" name="producto_id[<?php echo $a->producto_imagen_id ?>]"></td>
									<td>
										<?php list($url,$size) = returnThumbnailImage($a->imagen,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
										<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
									</td>
									<td><input type="text" class="form-control" value="<?php echo $a->orden ?>" name="orden[<?php echo $a->producto_imagen_id ?>]"></td>
									<td align="center" width="100px">
					        			<a title="<?php echo showLang($lang, "TABLE_DELETE") ?>" class="tip-top delete" class="tip-top delete" data-txt="<?php echo showLang($lang, 'PRODUCTO_IMAGEN_DELETE_CONFIRM') ?>" data-href="producto_imagenes.php?action=delete&amp;ids=<?php echo $a->producto_imagen_id ?>">
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
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>multipleUpload("ajax/upload-image-producto_imagen.php")</script>
<script>sortableTable("ajax/save-producto_imagen.php")</script>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>