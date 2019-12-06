<?php 

class Compra{
	public $compra_id = null;
	public $producto_id = null;
	public $vendedor_id = null;
	public $codigo = null;
	public $email = null;
	public $estado = null;
	public $session_id = null;
	public $fecha_expiracion = null;
	public $fecha_compra = null;

	public function __construct( $data=array() ) {
		if (isset($data["compra_id"])) $this->compra_id = $data["compra_id"];
		if (isset($data["producto_id"])) $this->producto_id = $data["producto_id"];
		if (isset($data["vendedor_id"])) $this->vendedor_id = $data["vendedor_id"];
		if (isset($data["codigo"])) $this->codigo = $data["codigo"];
		if (isset($data["email"])) $this->email = $data["email"];
		if (isset($data["estado"])) $this->estado = $data["estado"];
		if (isset($data["session_id"])) $this->session_id = $data["session_id"];
		if (isset($data["fecha_expiracion"])) $this->fecha_expiracion = $data["fecha_expiracion"];
		if (isset($data["fecha_compra"])) $this->fecha_compra = $data["fecha_compra"];
	}

	public static function getById( $compra_id ) {
	    $result = ConnectionFactory::getFactory()->getByArray("compra", array("compra_id"), array($compra_id), "Compra");
	    return $result["object"];
	}

	public static function getAllList() {
	    $result = ConnectionFactory::getFactory()->getList("compra", "Compra", null, null, null );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
	    $result = ConnectionFactory::getFactory()->delete("compra", "compra_id", $this->compra_id);
	}

	public function deleteAll() {
	    ConnectionFactory::getFactory()->executeStmtNotGet("delete from compra");
	}

	public function validateBeforeInsert(){
		$error = false;
		return $error;
	}

	public function insert() {
	    $error = $this->validateBeforeInsert();
		$id = "0";
	    if (!$error){ 
			$fields = array("producto_id","vendedor_id","codigo","email","estado","session_id","fecha_expiracion");
			$result = ConnectionFactory::getFactory()->insert($this, "compra", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"]; 
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->compra_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
	    if (!$error){ 
			$fields = array("producto_id","vendedor_id","codigo","email","estado","session_id","fecha_expiracion");
			$error = ConnectionFactory::getFactory()->update($this, "compra", $fields, "compra_id");
			if ($error) $error = array($error);
		}
	    return array("error" => $error, "id" => $this->compra_id);
	}
		
	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "compra", $fields, "compra_id");
	}
}
?>