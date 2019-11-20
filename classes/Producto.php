<?php

class Producto{
	public $producto_id = null;
	public $vendedor_id = null;
	public $nombre = null;
	public $precio = null;
	public $descuento = null;
	public $foto = null;
	public $duracion = null;
	public $descripcion = null;
	public $eliminado = null;
	public $categorias = null;

	public function __construct( $data=array() ) {
		if (isset($data["producto_id"])) $this->producto_id = $data["producto_id"];
		if (isset($data["vendedor_id"])) $this->vendedor_id = $data["vendedor_id"];
		if (isset($data["nombre"])) $this->nombre = $data["nombre"];
		if (isset($data["precio"])) $this->precio = $data["precio"];
		if (isset($data["descuento"])) $this->descuento = $data["descuento"];
		if (isset($data["foto"])) $this->foto = $data["foto"];
		if (isset($data["duracion"])) $this->duracion = $data["duracion"];
		if (isset($data["descripcion"])) $this->descripcion = $data["descripcion"];
		if (isset($data["eliminado"])) $this->eliminado = $data["eliminado"];
		if (isset($data["categorias"])) $this->categorias = $data["categorias"];
	}

	public static function getById( $producto_id ) {
	    $result = ConnectionFactory::getFactory()->getByArray("producto", array("producto_id"), array($producto_id), "Producto");
	    return $result["object"];
	}

	public static function getList($page) {
	    $rows = getAdminCookieValue("PRODS_PER_PAGE");
	    if (!$rows || !ctype_digit($rows)) $rows = DEFAULT_ROWS;
	    $limit1 = ($page-1)*$rows;
	    $limit2 = $rows;
	    $result = ConnectionFactory::getFactory()->getList("producto", "Producto", " $limit1,$limit2 ", array("eliminado = 0"), null );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getAllList() {
	    $result = ConnectionFactory::getFactory()->getList("producto", "Producto", null, null, null );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
	    $result = ConnectionFactory::getFactory()->delete("producto", "producto_id", $this->producto_id);
	}

	public function deleteAll() {
	    ConnectionFactory::getFactory()->executeStmtNotGet("delete from producto");
	}

	public function validateBeforeInsert(){
		$error = false;
		if ($this->nombre == '' ) $error[] = 'PRODUCTO_ERROR_1';
		if ($this->precio == '' ) $error[] = 'PRODUCTO_ERROR_2';
		if ($this->duracion == '' ) $error[] = 'PRODUCTO_ERROR_3';
		return $error;
	}

	public function insert() {
	    $error = $this->validateBeforeInsert();
		$id = "0";
	    if (!$error){
			$fields = array("vendedor_id","nombre","precio","descuento","foto","duracion","descripcion","eliminado","categorias");
			$result = ConnectionFactory::getFactory()->insert($this, "producto", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->producto_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
	    if (!$error){
			$fields = array("vendedor_id","nombre","precio","descuento","foto","duracion","descripcion","eliminado","categorias");
			$error = ConnectionFactory::getFactory()->update($this, "producto", $fields, "producto_id");
			if ($error) $error = array($error);
		}
	    return array("error" => $error, "id" => $this->producto_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "producto", $fields, "producto_id");
	}
}
?>
