<?php 
include_once dirname(__FILE__)."/../../config.php";
include ADMIN_PAGES_PATH."security.php";
$ids = isset($_POST["ids"]) ? $_POST["ids"] : array();

foreach ($ids as $n => $id){
	$producto_imagen = ProductoImagen::getById($id);
	if ($producto_imagen) {
		$producto_imagen->orden = $n + 1;
		ConnectionFactory::getFactory()->update($producto_imagen, "producto_imagen", array("orden"), "producto_imagen_id");
	}
}
?>