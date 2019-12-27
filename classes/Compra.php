<?php 

class Compra{
	public $compra_id = null;
	public $producto_id = null;
	public $vendedor_id = null;
	public $codigo = null;
	public $email = null;
	public $estado = null;                     ////0: No Visto; 2: Expirado; 1: Usado
	public $session_id = null;
	public $fecha_expiracion = null;
	public $fecha_compra = null;
	public $total = null;

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
		if (isset($data["total"])) $this->total = $data["total"];
	}

	public static function getById( $compra_id ) {
	    $result = ConnectionFactory::getFactory()->getByArray("compra", array("compra_id"), array($compra_id), "Compra");
	    return $result["object"];
	}
	
	public static function getBySession($sid) {
	    $result = ConnectionFactory::getFactory()->getByArray("compra", array("session_id"), array($sid), "Compra");
	    return $result["object"];
	}

	public static function getAllList($vid) {
	    $where = array();
	    if ($vid && $vid != '') $where[] = " vendedor_id = $vid ";
	    $result = ConnectionFactory::getFactory()->getList("compra", "Compra", null, $where, null );
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
			$fields = array("producto_id","vendedor_id","codigo","email","estado","session_id","fecha_expiracion","total");
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
			$fields = array("producto_id","vendedor_id","codigo","email","estado","session_id","fecha_expiracion","total");
			$error = ConnectionFactory::getFactory()->update($this, "compra", $fields, "compra_id");
			if ($error) $error = array($error);
		}
	    return array("error" => $error, "id" => $this->compra_id);
	}
		
	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "compra", $fields, "compra_id");
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////
	
	public static function getIndex($vid = 0) {
	    $where = array();
	    if ($vid && $vid != '') $where[] = " vendedor_id = $vid ";
	    $rows = 5;
	    $result = ConnectionFactory::getFactory()->getList("compra", "Compra", $rows, $where, "compra_id desc" );
	    return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}
	
	//////////////////////////////////////// STATS ////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	
	public static function getSalesAmount($month = false, $year = false, $vid = 0){
	    $stmt = "select sum(total) c from compra where estado = 1 ";
	    if ($month) $stmt .= " and MONTH(fecha_compra) = '$month' ";
	    if ($year) $stmt .= " and YEAR(fecha_compra) = '$year' ";
	    if ($vid && $vid != '') $stmt .= " and vendedor_id = '$vid' ";
	    return getTotalRows($stmt);
	}
	
	public static function getSalesAmountYear($year){
	    $mysqli = ConnectionFactory::getFactory()->getConnection();
	    $stmt = "select MONTH(fecha_compra) m, sum(total) t from compra where estado = 1 and YEAR(fecha_compra) = ? group by MONTH(fecha_compra)";
	    $sql = $mysqli->prepare($stmt);
	    $sql->bind_param("i", $year);
	    $sql->execute();
	    $row = $list = array();
	    db_bind_array($sql, $row);
	    while ($sql->fetch()) {
	        if (!isset($list[$row['m']])) $list[$row['m']] = 0;
	        $list[$row['m']] += round($row['t']);
	    }
	    return $list;
	}
	
	public static function getNumberOfSales($status = false, $vid = 0){
	    $stmt2 = "SELECT count(*) c FROM compra where 1 = 1";
	    if ($status !== false) $stmt2 .= " and estado in (".implode(',', $status).") ";
	    if ($vid && $vid != '') $stmt2 .= " and vendedor_id = '$vid' ";
	    return getTotalRows($stmt2);
	}
	
	public static function getYearsSelect($name){
	    $mysqli = ConnectionFactory::getFactory()->getConnection();
	    $sql = $mysqli->prepare("select distinct(YEAR(fecha_compra)) y from compra order by y desc");
	    $sql->execute();
	    $row = $list = array();
	    db_bind_array($sql, $row);
	    while ($sql->fetch()) $list[] = $row['y'];
	    $select = '<select class="salesYears" name="'.$name.'">';
	    foreach ($list as $y){$select .= '<option value="'.$y.'"';$select .= '>'.$y.'</option>';}
	    $select .= '</select>';
	    return $select;
	}
}
?>