<?php

class ExtraVariables{
	public $extra_variables_id = null;
	public $name = null;
	public $value = null;
	public $module = null;

	public function __construct( $data=array() ) {
		if ( isset( $data["extra_variables_id"])) $this->extra_variables_id = $data["extra_variables_id"];
		if ( isset( $data["name"])) $this->name = $data["name"];
		if ( isset( $data["value"])) $this->value = $data["value"];
		if ( isset( $data["module"])) $this->module = $data["module"];
	}

	public static function getById( $extra_variables_id ) {
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("SELECT * FROM extra_variables WHERE extra_variables_id = ? LIMIT 1");
		$sql->bind_param("i", $extra_variables_id);
		$sql->execute();
		$row = array(); db_bind_array($sql, $row); $sql->fetch();
		$sql->close();
		if ( $row["extra_variables_id"] != "" ) return new ExtraVariables( $row );
	}

	public static function getByName( $name ) {
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("SELECT * FROM extra_variables WHERE name = ? LIMIT 1");
		$sql->bind_param("s", $name);
		$sql->execute();
		$row = array(); db_bind_array($sql, $row); $sql->fetch();
		$sql->close();
		if ( $row["extra_variables_id"] != "" ) return new ExtraVariables( $row );
	}

	public static function getList() {
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("SELECT * FROM extra_variables");
		$sql->execute();
		$row = $list = array();
		db_bind_array($sql, $row);
		while ($sql->fetch()) $list[] = new ExtraVariables( $row );
		$sql->close();
		$totalRows = count($list);
		return ( array ( "results" => $list, "totalRows" => $totalRows ) );
	}

	public static function getListByModule($module) {
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("SELECT * FROM extra_variables where module = ?");
		$sql->bind_param("i", $module);
		$sql->execute();
		$row = $list = array();
		db_bind_array($sql, $row);
		while ($sql->fetch()) $list[$row['name']] = $row['value'];
		$sql->close();
		return $list;
	}

	public static function getListByModules($modules) {
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("SELECT * FROM extra_variables where module in (".implode($modules,',').")");
		$sql->execute();
		$row = $list = array();
		db_bind_array($sql, $row);
		while ($sql->fetch()) $list[$row['name']] = $row['value'];
		$sql->close();
		return $list;
	}

	public function delete() {
		if ( is_null( $this->extra_variables_id ) ) trigger_error ( "Delete Error", E_USER_ERROR );
		$mysqli = ConnectionFactory::getFactory()->getConnection();
		$sql = $mysqli->prepare("DELETE FROM extra_variables WHERE extra_variables_id = ? LIMIT 1" );
		$sql->bind_param("i", $this->extra_variables_id);
		$sql->execute();
		$sql->close();
	}

	public function validateBeforeInsert(){
		$error = false;
		return $error;
	}

	public function insert() {
		$error = $this->validateBeforeInsert();
		if (!$error){
			$mysqli = ConnectionFactory::getFactory()->getConnection();
			$sql = $mysqli->prepare("INSERT INTO extra_variables (name, value, module) VALUES ( ?,?,? )");
			$sql->bind_param("ssi", $this->name,$this->value,$this->module);
			$sql->execute();
			$sql->close();
		}
		return $error;
	}

	public function update() {
		if ( is_null( $this->extra_variables_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
		if (!$error){
			$mysqli = ConnectionFactory::getFactory()->getConnection();
			$sql = $mysqli->prepare("UPDATE extra_variables SET name = ?, value = ?, module = ? WHERE extra_variables_id = ? ");
			$sql->bind_param("ssii", $this->name,$this->value,$this->module,$this->extra_variables_id);
			$sql->execute();
			$sql->close();
		}
		return $error;
	}
}
?>
