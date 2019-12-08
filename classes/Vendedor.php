<?php

class Vendedor{
	public $vendedor_id = null;
	public $nombre = null;
	public $apellido = null;
	public $nombre_tienda = null;
	public $url = null;
	public $direccion = null;
	public $telefono = null;
	public $mail = null;
	public $u1_id = null;

	public function __construct( $data=array() ) {
		if (isset($data["vendedor_id"])) $this->vendedor_id = $data["vendedor_id"];
		if (isset($data["nombre"])) $this->nombre = $data["nombre"];
		if (isset($data["apellido"])) $this->apellido = $data["apellido"];
		if (isset($data["nombre_tienda"])) $this->nombre_tienda = $data["nombre_tienda"];
		if (isset($data["url"])) $this->url = $data["url"];
		if (isset($data["direccion"])) $this->direccion = $data["direccion"];
		if (isset($data["telefono"])) $this->telefono = $data["telefono"];
		if (isset($data["mail"])) $this->mail = $data["mail"];
		if (isset($data["u1_id"])) $this->u1_id = $data["u1_id"];
	}

	public static function getById( $vendedor_id ) {
	    $result = ConnectionFactory::getFactory()->getByArray("vendedor", array("vendedor_id"), array($vendedor_id), "Vendedor");
	    return $result["object"];
	}

	public static function getByU1($u1) {
		$result = ConnectionFactory::getFactory()->getByArray("vendedor", array("u1_id"), array($u1), "Vendedor");
		return $result["object"];
	}

	public static function getByUrl($url) {
		$result = ConnectionFactory::getFactory()->getByArray("vendedor", array("url"), array($url), "Vendedor");
		return $result["object"];
	}

	public static function getAllList() {
	    $result = ConnectionFactory::getFactory()->getList("vendedor", "Vendedor", null, null, null );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
	    $result = ConnectionFactory::getFactory()->delete("vendedor", "vendedor_id", $this->vendedor_id);
	}

	public function deleteAll() {
	    ConnectionFactory::getFactory()->executeStmtNotGet("delete from vendedor");
	}

	public function validateBeforeInsert(){
		$error = false;
		if ($this->nombre_tienda == '' ) $error[] = 'VENDEDOR_ERROR_1';
		if ($this->url == '' ) $error[] = 'VENDEDOR_ERROR_2';
		if ($this->mail == '' ) $error[] = 'VENDEDOR_ERROR_3';
		return $error;
	}

	public function insert() {
	    $error = $this->validateBeforeInsert();
		$id = "0";
	    if (!$error){
			$fields = array("nombre","apellido","nombre_tienda","url","direccion","telefono","mail","u1_id");
			$result = ConnectionFactory::getFactory()->insert($this, "vendedor", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->vendedor_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
	    if (!$error){
			$fields = array("nombre","apellido","nombre_tienda","url","direccion","telefono","mail","u1_id");
			$error = ConnectionFactory::getFactory()->update($this, "vendedor", $fields, "vendedor_id");
			if ($error) $error = array($error);
		}
	    return array("error" => $error, "id" => $this->vendedor_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "vendedor", $fields, "vendedor_id");
	}
}
?>
