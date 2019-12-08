<?php
class ConnectionFactory{

	private static $factory;
	private $db;

	public static function getFactory(){
	   if (!self::$factory){
	      self::$factory = new ConnectionFactory();
	   }
	   return self::$factory;
	}

	public function getConnection(){
	   if (is_null($this->db)) $this->db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	   return $this->db;
	}

	public function closeConnection(){
	   if (!is_null($this->db)){
	      $db = $this->db;
	      $db->close();
	      $this->db = null;
	   }
	}

	public static function writeLog($stmt){
		if (MYSQLI_DEBUG){
			$file = WEB_PATH.'log-mysqli.log';
			$txt = date("Y-m-d H:i:s")."\t\t";
			$txt .= $stmt.PHP_EOL;;
			file_put_contents($file, $txt, FILE_APPEND | LOCK_EX);
		}
	}

	public function insert($object, $table, $fields){
		$id = 0;
		$error = false;
		try {
			$mysqli = $this->db;
			$stmt = "insert into $table (".implode(' , ', $fields).") values ('";
			$values = array();
			foreach ($fields as $field){$values[] = (isset($object->$field)) ? $mysqli->real_escape_string($object->$field) : '';}
			$stmt .= implode("' , '", $values);
			$stmt .= "')";
			ConnectionFactory::writeLog($stmt);
			if ($mysqli->query($stmt) === TRUE) $id = $mysqli->insert_id;
			else $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return array('error' => $error, 'id' => $id);
	}

	public function update($object, $table, $fields, $key){
		$mysqli = $this->db;
		$id = (isset($object->$key)) ? $mysqli->real_escape_string($object->$key) : '';
		$error = false;
		if ($id && $id != ''){
			try {
				$stmt = "update $table set ";
				$updateaeble = array();
				foreach ($fields as $field){
					$value = (isset($object->$field)) ? $mysqli->real_escape_string($object->$field) : '';
					$updateaeble[] = " $field = '$value'";
				}
				$stmt .= implode(',', $updateaeble)." where $key = '$id'";
				ConnectionFactory::writeLog($stmt);
				if ($mysqli->query($stmt) !== TRUE) $error = $mysqli->error;
			}catch (Exception $e){
				$error = $e->getMessage();
			}
		}else $error = 'Falta el ID';
		return $error;
	}

	public function getByArray($table, $fields, $values, $class){
		$error = false;
		$object = null;
		$mysqli = $this->db;
		$field = isset($fields[0]) ? $fields[0] : '';
		try {
			$stmt = "select * from $table where ";
			$vars = array();
			foreach ($fields as $n => $field){
				$value = (isset($values[$n])) ? $mysqli->real_escape_string($values[$n]) : '';
				$vars[] = " $field = '$value'";
			}
			$stmt .= implode(' and ', $vars);
			$stmt .= ' LIMIT 1';
			ConnectionFactory::writeLog($stmt);
			if ($result = $mysqli->query($stmt)) {
				$row = $result->fetch_assoc();
				if (isset($row[$field]) && $row[$field] != '') $object = new $class($row); else $object = null;
    			$result->free();
			}
			else $error = $mysqli->error;
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		return array('error' => $error, 'object' => $object);
	}

	public function getList($table, $class, $limit = null, $where = array(), $orderBy = null){
		$error = false;
		$object = null;
		$totalRows = 0;
		$mysqli = $this->db;
		$list = array();
		try {
			$stmt = "select * from $table ";
			if ($where && count($where) != 0){
				$stmt .= ' where ';
				$stmt .= implode(' and ', $where);
			}

			if ($orderBy && $orderBy != '') $stmt .= ' order by '.$orderBy;
			if ($limit && $limit != '') {
				$stmt2 = "select count(*) c from ($stmt)t1";
				$stmt .= ' LIMIT '.$limit;
			}
			ConnectionFactory::writeLog($stmt);
			if ($result = $mysqli->query($stmt)) {
				while ($row = $result->fetch_assoc()) $list[] = new $class($row);
    			$result->free();
    			if ($limit && $limit != '') {
    				ConnectionFactory::writeLog($stmt2);
    				$totalRows = getTotalRows($stmt2);
    			}else $totalRows = count($list);
			} else $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return array('error' => $error, 'list' => $list, 'totalRows' => $totalRows);
	}

	public function getRandomList($table, $class, $limit = 1){
		$error = false;
		$object = null;
		$totalRows = 0;
		$mysqli = $this->db;
		$list = array();
		try {
			$stmt = "select * from $table order by rand()";
			if ($limit && $limit != '') {
				$stmt .= ' limit '.$limit;
			}

			ConnectionFactory::writeLog($stmt);
			if ($result = $mysqli->query($stmt)) {
				while ($row = $result->fetch_assoc()) $list[] = new $class($row);
    			$result->free();
			} else $error = $mysqli->error;

		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return array('error' => $error, 'list' => $list);
	}

	public function executeStmt($stmt, $class = null){
		$error = false;
		$object = null;
		$totalRows = 0;
		$mysqli = $this->db;
		$list = array();
		try {
			ConnectionFactory::writeLog($stmt);
			if ($result = $mysqli->query($stmt)) {
				while ($row = $result->fetch_assoc()) $list[] = $class ? new $class($row) : copyArray($row);
				$result->free();
				$totalRows = count($list);
			} else $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return array('error' => $error, 'list' => $list, 'totalRows' => $totalRows);
	}

	public function executeStmtNotGet($stmt){
		$error = false;
		$mysqli = $this->db;
		try {
			ConnectionFactory::writeLog($stmt);
			if ($result = $mysqli->query($stmt)) {
			} else $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return array('error' => $error);
	}

	public function delete($table, $field, $key){
		$mysqli = $this->db;
		if ($key && $key != '' && $field && $field != ''){
			$error = false;
			try {
				$value = $mysqli->real_escape_string($key);
				$stmt = "delete from $table where $field = $value";
				ConnectionFactory::writeLog($stmt);
				if ($mysqli->query($stmt) !== TRUE) $error = $mysqli->error;
			}catch (Exception $e){
				$error = $e->getMessage();
			}
		}else $error = 'Falta el ID';
		return $error;
	}

	public function deleteAll($table){
		$error = false;
		$mysqli = $this->db;
		try {
			$stmt = "delete from $table";
			ConnectionFactory::writeLog($stmt);
			if ($mysqli->query($stmt) !== TRUE) $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return $error;
	}

	public function trucate($table){
		$error = false;
		$mysqli = $this->db;
		try {
			$stmt = "truncate table $table";
			ConnectionFactory::writeLog($stmt);
			if ($mysqli->query($stmt) !== TRUE) $error = $mysqli->error;
		}catch (Exception $e){
			$error = $e->getMessage();
		}
		return $error;
	}

	public function scapeString($string){
		return $this->db->real_escape_string($string);
	}
}
