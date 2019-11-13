<?php
require_once "header.php";
$results = array();
$results["lang"] = $lang;

function callback($buffer){}
		
$action = isset( $_GET["action"] ) ? $_GET["action"] : "";
switch ( $action ) { 	
	case "crop":
		cropImage($results);
		break;
	case "delete":
	    deleteProducto($results);
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
            $results["x"] = 100;
			$results["y"] = 100;
			$results["image"] = $image->foto;
			$results["imageUrl"] = IMAGES_PATH_HTML.$image->foto;
			$results["cropPath"] = IMAGES_PATH."crop".$_GET["n"]."/";
		}
		cropFotoImage($results);
	}
}
			
function deleteProducto() {
	if ( !$producto = Producto::getById(isset($_GET["id"]) ? $_GET["id"] : "")) {
		header( "Location: productos.php?error=productoNotFound" );
		exit();
	}
	$producto->delete();
	header( "Location: productos.php?status=productoDeleted" );
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
			<div class="widget-box">
				<div class="widget-content">
					<?php echo showLang($lang, "DRAG_DROP_INFO") ?><br>
					<input id="fileToUpload" type="file" size="45" name="fileToUpload[]" class="input" accept="image/*" multiple>
				</div>
			</div>
			<div class="widget-box with-table">
				<div class="widget-content nopadding">
					<form action="productos.php" method="post">
						<table class="table table-bordered table-striped table-hover table-condensed ">
							<thead>
								<tr>
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
									<td><input type="text" class="form-control" value="<?php echo $a->producto_id ?>" name="producto_id[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->vendedor_id ?>" name="vendedor_id[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->nombre ?>" name="nombre[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->precio ?>" name="precio[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->descuento ?>" name="descuento[<?php echo $a->producto_id ?>]"></td>
									<td>
										<?php list($url,$size) = returnThumbnailImage($a->foto,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
										<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
									</td>
									<td>
										<?php list($url,$size) = returnThumbnailImage($a->foto,IMAGES_PATHH_HTML."crop/",IMAGES_PATH."crop/",100,100,"",""); ?>
										<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
										<br><a href="productos.php?action=crop&id=<?php echo $a->producto_id ?>&n=5"><?php echo showLang($lang, "CROP") ?></a>
									</td>
									<td><input type="text" class="form-control" value="<?php echo $a->duracion ?>" name="duracion[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->descripcion ?>" name="descripcion[<?php echo $a->producto_id ?>]"></td>
									<td><input type="text" class="form-control" value="<?php echo $a->eliminado ?>" name="eliminado[<?php echo $a->producto_id ?>]"></td>
									<td>
										<?php list($url,$size) = returnThumbnailImage($a->categorias,IMAGES_PATH_HTML,IMAGES_PATH,100,100,ADMIN_IMAGES_PATH_HTML.'nopic.jpg',ADMIN_IMAGES_PATH.'nopic.jpg'); ?>
										<?php if ($url && $url != ""){ ?><img src="<?php echo $url ?>" width="<?php echo $size[0] ?>" height="<?php echo $size[1] ?>"><?php } ?>
									</td>
									<td align="center" width="100px">
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
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>multipleUpload("ajax/upload-image-producto.php")</script>
<?php } ?>

<?php require dirname(__FILE__)."/footer.php"; ?>