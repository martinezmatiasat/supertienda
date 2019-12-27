<?php
if (isset($_SESSION['userId'])){
	$session = U1::getSession();
	if ( $session == null){
		header("Location: ".ADMIN_PAGES_PATH_HTML."login.php");
		exit();
	}
}else {
	header("Location: ".ADMIN_PAGES_PATH_HTML."login.php");
	exit();
}

////PERMISOS DE ACCESO
$pagina = basename($_SERVER['PHP_SELF']);
$pages = array("productos.php","productoImagenes.php","upload-image-producto_imagen.php","compras.php","get-sales-chart-multi.php"); /////AGREGAR TODAS LAS PAGINAS A LAS QUE EL VENDEDOR TIENE ACCESO
if ($session->rol == 1){
    $vendedor = Vendedor::getByU1($session->u1_id);
    if (!$vendedor){
        header("Location: ".ADMIN_PAGES_PATH_HTML."login.php");
        exit();
    }

    define ('VENDEDOR', TRUE);
    define ('VENDEDOR_ID', $vendedor->vendedor_id);
    if (!in_array($pagina, $pages) && $pagina != 'index.php'){
        header("Location: index.php");
        exit();
    }
}else {
    define ('VENDEDOR', FALSE);
    Define ('VENDEDOR_ID', 0);
    if (in_array($pagina, $pages) && $pagina != "compras.php"){
        header("Location: index.php");
        exit();
    }
}
?>
