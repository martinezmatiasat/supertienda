<?php

class U1{
	public $u1_id = null;
	public $usuario = null;
	public $clave = null;
	public $email = null;
	public $rol = null;

	public function __construct( $data=array() ) {
		if ( isset( $data["u1_id"])) $this->u1_id = $data["u1_id"];
		if ( isset( $data["usuario"])) $this->usuario = $data["usuario"];
		if ( isset( $data["clave"])) $this->clave = $data["clave"];
		if ( isset( $data["email"])) $this->email = $data["email"];
		if ( isset( $data["rol"])) $this->rol = $data["rol"];
	}

	public static function getById( $u1_id ) {
		$result = ConnectionFactory::getFactory()->getByArray("u1", array("u1_id"), array($u1_id), "U1");
		return $result["object"];
	}

	public static function getByUsuario($usuario) {
		$result = ConnectionFactory::getFactory()->getByArray("u1", array("usuario"), array($usuario), "U1");
		return $result["object"];
	}

	public static function getByEmail($email) {
		$result = ConnectionFactory::getFactory()->getByArray("u1", array("email"), array($email), "U1");
		return $result["object"];
	}

	public static function login($usuario, $clave) {
		$result = ConnectionFactory::getFactory()->getByArray("u1", array("usuario","clave"), array($usuario, $clave), "U1");
		return $result["object"];
	}

	public static function getList($page) {
		$rows = getAdminCookieValue("ADMINS_PER_PAGE");
		if (!$rows || !ctype_digit($rows)) $rows = DEFAULT_ROWS;
		$limit1 = ($page-1)*$rows;
		$limit2 = $rows;
		$result = ConnectionFactory::getFactory()->getList("u1", "U1", " $limit1,$limit2 ", null, null );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public static function getAllList() {
		$result = ConnectionFactory::getFactory()->getList("u1", "U1", null, null, null );
		return (array("results" => $result["list"], "totalRows" => $result["totalRows"]));
	}

	public function delete() {
		$result = ConnectionFactory::getFactory()->delete("u1", "u1_id", $this->u1_id);
	}

	public function validateBeforeInsert(){
		$error = false;
		if ($this->usuario == '' ) $error[] = 'U1_ERROR_1';
		else {
			$uu = U1::getByUsuario($this->email);
			if ($uu && $uu->u1_id != $this->u1_id) $error[] = 'U1_ERROR_3';
		}
		if ($this->email == '' ) $error[] = 'U1_ERROR_2';
		else {
			$uu = U1::getByEmail($this->email);
			if ($uu && $uu->u1_id != $this->u1_id) $error[] = 'U1_ERROR_4';
		}
		return $error;
	}

	public function insert() {
		$error = $this->validateBeforeInsert();
		$id = "0";
		if (!$error){
			$this->clave = sha1($this->clave);
			$fields = array("usuario","clave","email");
			$result = ConnectionFactory::getFactory()->insert($this, "u1", $fields);
			if ($result["error"]) $error = array($result["error"]);
			$id = $result["id"];
		}
		return array("error" => $error, "id" => $id);
	}

	public function update() {
		if ( is_null( $this->u1_id ) ) trigger_error ( "Update error", E_USER_ERROR );
		$error = $this->validateBeforeInsert();
		if (!$error){
			$fields = array("usuario","email");
			$error = ConnectionFactory::getFactory()->update($this, "u1", $fields, "u1_id");
			if ($error) $error = array($error);
		}
		return array("error" => $error, "id" => $this->u1_id);
	}

	public function updateFields($fields) {
		ConnectionFactory::getFactory()->update($this, "u1", $fields, "u1_id");
	}

	////////////////////////////////////////// ADMIN SESSIONS ////////////////////////////////////////////

	public static function deleteUserSession ($userId){
		ConnectionFactory::getFactory()->executeStmtNotGet("delete from admin_session where user_id = '$userId'");
	}

	public static function deleteSession ($sessionId){
		ConnectionFactory::getFactory()->executeStmtNotGet("delete from admin_session where session_id = '$sessionId'");
	}

	public static function createAdminSession($sessionId,$userId){
		ConnectionFactory::getFactory()->executeStmtNotGet("INSERT INTO admin_session (session_id, user_id) VALUES ( '$sessionId', '$userId')");
	}

	public static function getSession(){
		$sessionId = session_id();
		$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
		$results = ConnectionFactory::getFactory()->executeStmt("select * from admin_session where session_id = '$sessionId' and upper(user_id) = '$userId' LIMIT 1");
		if (isset($results['list'][0])) return U1::getById($results['list'][0]['user_id']);
	}

	public function generateSession(){
		$userId = $this->u1_id;
		$sessionId = session_id();
		$_SESSION['userId'] = $userId;
		$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		U1::deleteSession($sessionId);
		U1::deleteUserSession($userId);
		U1::createAdminSession($sessionId, $userId);
	}
}
?>
