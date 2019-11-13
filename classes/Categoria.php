<?php

class Categoria{
	public $categoria_id = null;
	public $subcategoria_id = null;
	public $nombre = null;
	public $imagen = null;
	public $destacada = null;
	public $orden = null;

	public function __construct( $data=array() ) {
		if (isset($data["categoria_id"])) $this->categoria_id = $data["categoria_id"];
		if (isset($data["subcategoria_id"])) $this->subcategoria_id = $data["subcategoria_id"];
		if (isset($data["nombre"])) $this->nombre = $data["nombre"];
		if (isset($data["imagen"])) $this->imagen = $data["imagen"];
		if (isset($data["destacada"])) $this->destacada = $data["destacada"];
		if (isset($data["orden"])) $this->orden = $data["orden"];
	}

	public static function getById( $categoria_id ) {
	    $result = ConnectionFactory::getFactory()->getByArray("categoria", array("categoria_id"), array($categoria_id), "Categoria");
	    return $result["object"];
	}

	public static function getAllList() {
	    $result = ConnectionFactory::getFactory()->getList("categoria", "Categoria", null, null, "orden" );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
	    $result = ConnectionFactory::getFactory()->delete("categoria", "categoria_id", $this->categoria_id);
		Categoria::reorderSliders($this->orden, $this->subcategoria_id);
	}

	public function deleteAll() {
	    ConnectionFactory::getFactory()->executeStmtNotGet("delete from categoria");
	}

	public function validateBeforeInsert(){
		$error = false;
		if ($this->nombre == '' ) $error[] = 'CATEGORIA_ERROR_1';
		return $error;
	}

	public function insert() {
	    $error = $this->validateBeforeInsert();
		$id = "0";
	    if (!$error){
			$this->orden = getTotalRows("select count(*) c from categoria where subcategoria_id = $this->subcategoria_id") + 1;
			if (isset($_FILES["imagen"]) && isset($_FILES["imagen"]["tmp_name"]) && $_FILES["imagen"]["tmp_name"] != ""){
			    $photo3 = returnEncryptedName($_FILES["imagen"]["name"],generateRandomString());
			}else $photo3 = null;
			$this->imagen = $photo3;

			$fields = array("subcategoria_id","nombre","imagen","destacada","orden");
			$result = ConnectionFactory::getFactory()->insert($this, "categoria", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
			if (isset($photo3) && $photo3 != null && $photo3 != "" && $id != "0") saveImageToPath(IMAGES_PATH,$photo3,'imagen',null);
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->categoria_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
	    if (!$error){
			if (isset($_FILES["imagen2"]) && isset($_FILES["imagen2"]["tmp_name"]) && $_FILES["imagen2"]["tmp_name"] != ""){
			    $photo3 = returnEncryptedName($_FILES["imagen2"]["name"],generateRandomString());
			    $old3 = Categoria::getById($this->categoria_id);
			}else $photo3 = $this->imagen;
			$this->imagen = $photo3;

			$fields = array("subcategoria_id","nombre","imagen","destacada");
			$error = ConnectionFactory::getFactory()->update($this, "categoria", $fields, "categoria_id");
			if ($error) $error = array($error);
			if (isset($photo3) && $photo3 != null && $photo3 != "" && isset($old3)) saveImageToPath(IMAGES_PATH,$photo3,'imagen2',$old3->imagen);
		}
	    return array("error" => $error, "id" => $this->categoria_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "categoria", $fields, "categoria_id");
	}

	public static function moveUp($order, $sid){
		$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$sql = $mysqli->prepare("update categoria set orden = 0 where orden = $order and subcategoria_id = $sid" );
	    $sql->execute();
	    $sql = $mysqli->prepare("update categoria set orden = $order where orden = $order - 1 and subcategoria_id = $sid" );
	    $sql->execute();
	    $sql = $mysqli->prepare("update categoria set orden = ($order - 1) where orden = 0 and subcategoria_id = $sid" );
	    $sql->execute();
	}

	public static function moveDown($order, $sid){
		$total = getTotalRows("select count(*) c from categoria");
		if ($order < $total){
	    	$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$sql = $mysqli->prepare("update categoria set orden = 0 where orden = $order and subcategoria_id = $sid" );
		    $sql->execute();
		    $sql = $mysqli->prepare("update categoria set orden = $order where orden = $order + 1 and subcategoria_id = $sid" );
		    $sql->execute();
		    $sql = $mysqli->prepare("update categoria set orden = ($order + 1) where orden = 0 and subcategoria_id = $sid" );
		    $sql->execute();
		}
	}

	public static function reorderSliders($from, $sid){
		$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$sql = "update categoria set orden = (orden - 1) where orden > $from and subcategoria_id = $sid";
		$sql = $mysqli->prepare($sql );
		$sql->execute();
	}

	public static function getAllListSubcategoria($sid) {
		$result = ConnectionFactory::getFactory()->getList("categoria", "Categoria", null, array("subcategoria_id = $sid"), "orden" );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}
}
?>
