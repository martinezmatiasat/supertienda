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

	public static function getByUrl($url) {
		$result = ConnectionFactory::getFactory()->getByArray("producto", array("url","eliminado"), array($url,0), "Producto");
		return $result["object"];
	}

	public static function getList($page, $vid) {
		$rows = getAdminCookieValue("PRODS_PER_PAGE");
		if (!$rows || !ctype_digit($rows)) $rows = DEFAULT_ROWS;
		$limit1 = ($page-1)*$rows;
		$limit2 = $rows;
		$result = ConnectionFactory::getFactory()->getList("producto", "Producto", " $limit1,$limit2 ", array("eliminado = 0"), null );
		$result = ConnectionFactory::getFactory()->getList("producto", "Producto", " $limit1,$limit2 ", array("eliminado = 0", "vendedor_id = $vid"), null );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getAllList() {
		$result = ConnectionFactory::getFactory()->getList("producto", "Producto", null, null, null );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getIndex() {
	    $result = ConnectionFactory::getFactory()->getList("producto", "Producto", 10, array("descuento != 0", "eliminado = 0"), "rand()" );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getRelacionados($p){
	    $cats = explode(',', $p->categorias);
	    $ors = array();
	    foreach ($cats as $c){
	        if ($c && $c != '') $ors[] = " categorias like '%$c%' ";
	    }
	    $where = array(implode(' or ', $ors));
	    $result = ConnectionFactory::getFactory()->getList("producto", "Producto", 10, $where, "rand()" );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getRandom() {
		$result = ConnectionFactory::getFactory()->getRandomList("producto", "Producto", 8);
		return (array("results" => $result["list"]));
	}

	public function delete() {
		$this->eliminado = 1;
		$this->updateFields(array("eliminado"));
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
			if (isset($_FILES["foto"]) && isset($_FILES["foto"]["tmp_name"]) && $_FILES["foto"]["tmp_name"] != ""){
				$photo9 = returnEncryptedName($_FILES["foto"]["name"],generateRandomString());
			}else $photo9 = null;
			$this->foto = $photo9;

			var_dump($photo9);

			$fields = array("vendedor_id","nombre","precio","descuento","foto","duracion","descripcion","eliminado","categorias");
			$result = ConnectionFactory::getFactory()->insert($this, "producto", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
			if (isset($photo9) && $photo9 != null && $photo9 != "" && $id != "0") saveImageToPath(PRODUCTOS_PATH,$photo9,'foto',null);
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->producto_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
		if (!$error){
			if (isset($_FILES["foto2"]) && isset($_FILES["foto2"]["tmp_name"]) && $_FILES["foto2"]["tmp_name"] != ""){
				$photo9 = returnEncryptedName($_FILES["foto2"]["name"],generateRandomString());
				$old9 = Producto::getById($this->producto_id);
			}else $photo9 = $this->foto;
			$this->foto = $photo9;

			$fields = array("vendedor_id","nombre","precio","descuento","foto","duracion","descripcion","eliminado","categorias");
			$error = ConnectionFactory::getFactory()->update($this, "producto", $fields, "producto_id");
			if ($error) $error = array($error);
			if (isset($photo9) && $photo9 != null && $photo9 != "" && isset($old9)) saveImageToPath(PRODUCTOS_PATH,$photo9,'foto2',$old9->foto);
		}
		return array("error" => $error, "id" => $this->producto_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "producto", $fields, "producto_id");
	}

	public static function getProductosSelect($name, $selected){
		$productos = Producto::getAllList();
		$select = '<select class="select2" id="'.$name.'" name="'.$name.'" style="max-width: 600px;"><option></option>';
		foreach ($productos['results'] as $prod){
			$select .= '<option value="'.$prod->producto_id.'"';
			if ($prod->producto_id == $selected)$select .= ' selected="selected" ';
			$select .= '>'.$prod->nombre.'</option>';
		}
		$select .= '</select>';
		return $select;
	}

	public static function getProductosSelectAllowed($name, $selected, $allowed){
		$productos = Producto::getAllList();
		$select = '<select class="pid" name="'.$name.'" style="max-width: 300px;"><option></option>';
		foreach ($productos['results'] as $prod){
			if (in_array($prod->producto_id, $allowed)){
				$select .= '<option value="'.$prod->producto_id.'"';
				if ($prod->producto_id == $selected)$select .= ' selected="selected" ';
				$select .= '>'.$prod->nombre.'</option>';
			}
		}
		$select .= '</select>';
		return $select;
	}

}
?>
