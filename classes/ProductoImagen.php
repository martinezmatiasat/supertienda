<?php

class ProductoImagen{
	public $producto_imagen_id = null;
	public $producto_id = null;
	public $imagen = null;
	public $orden = null;

	public function __construct( $data=array() ) {
		if (isset($data["producto_imagen_id"])) $this->producto_imagen_id = $data["producto_imagen_id"];
		if (isset($data["producto_id"])) $this->producto_id = $data["producto_id"];
		if (isset($data["imagen"])) $this->imagen = $data["imagen"];
		if (isset($data["orden"])) $this->orden = $data["orden"];
	}

	public static function getById( $producto_imagen_id ) {
		$result = ConnectionFactory::getFactory()->getByArray("producto_imagen", array("producto_imagen_id"), array($producto_imagen_id), "ProductoImagen");
		return $result["object"];
	}

	public static function getAllList($pid) {
		$result = ConnectionFactory::getFactory()->getList("producto_imagen", "ProductoImagen", null, array("producto_id = $pid"), "orden" );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
		$result = ConnectionFactory::getFactory()->delete("producto_imagen", "producto_imagen_id", $this->producto_imagen_id);
		ProductoImagen::reorderSliders($this->orden, $pid);
	}

	public function deleteAll() {
		ConnectionFactory::getFactory()->executeStmtNotGet("delete from producto_imagen");
	}

	public function validateBeforeInsert(){
		$error = false;
		return $error;
	}

	public function insert() {
		$error = $this->validateBeforeInsert();
		$id = "0";
		if (!$error){
			$this->orden = getTotalRows("select count(*) c from producto_imagen where producto_id = $this->producto_id") + 1;
			$fields = array("producto_id","imagen","orden");
			$result = ConnectionFactory::getFactory()->insert($this, "producto_imagen", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->producto_imagen_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
		if (!$error){
			$fields = array("producto_id","imagen");
			$error = ConnectionFactory::getFactory()->update($this, "producto_imagen", $fields, "producto_imagen_id");
			if ($error) $error = array($error);
		}
		return array("error" => $error, "id" => $this->producto_imagen_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "producto_imagen", $fields, "producto_imagen_id");
	}

	public static function moveUp($order, $pid){
		$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$sql = $mysqli->prepare("update producto_imagen set orden = 0 where orden = $order and producto_id = $pid" );
		$sql->execute();
		$sql = $mysqli->prepare("update producto_imagen set orden = $order where orden = $order - 1 and producto_id = $pid" );
		$sql->execute();
		$sql = $mysqli->prepare("update producto_imagen set orden = ($order - 1) where orden = 0 and producto_id = $pid" );
		$sql->execute();
	}

	public static function moveDown($order, $pid){
		$total = getTotalRows("select count(*) c from producto_imagen");
		if ($order < $total){
			$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$sql = $mysqli->prepare("update producto_imagen set orden = 0 where orden = $order and producto_id = $pid" );
			$sql->execute();
			$sql = $mysqli->prepare("update producto_imagen set orden = $order where orden = $order + 1 and producto_id = $pid" );
			$sql->execute();
			$sql = $mysqli->prepare("update producto_imagen set orden = ($order + 1) where orden = 0 and producto_id = $pid" );
			$sql->execute();
		}
	}

	public static function reorderSliders($from, $pid){
		$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$sql = "update producto_imagen set orden = (orden - 1) where orden > $from and producto_id = $pid";
		$sql = $mysqli->prepare($sql );
		$sql->execute();
	}
}
?>
