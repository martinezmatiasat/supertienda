<?php 
include_once dirname(__FILE__)."/../../config.php";
include ADMIN_PAGES_PATH."security.php";
$ids = isset($_POST["ids"]) ? $_POST["ids"] : array();

foreach ($ids as $n => $id){
	$categoria = Categoria::getById($id);
	if ($categoria) {
		$categoria->orden = $n + 1;
		ConnectionFactory::getFactory()->update($categoria, "categoria", array("orden"), "categoria_id");
	}
}
?>