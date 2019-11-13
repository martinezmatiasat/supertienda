<?php 
////SYSTEM VARIABLES
$mysqli = ConnectionFactory::getFactory()->getConnection();
$sql = $mysqli->prepare("SELECT * FROM system_variables WHERE system_variables_id = 1 LIMIT 1");
$sql->execute();
$row = array(); db_bind_array($sql, $row); $sql->fetch();
$sql->close();
foreach ($row as $name => $value) define($name, $value);

////EMAIL VARIABLES
$emailVars = ExtraVariables::getListByModule(1);
foreach ($emailVars as $name => $value) define($name, $value);
?>