<?php
class Compra {
   public $compra_id = null;
   public $producto_id  = null;
   public $vendedor_id  = null;
   public $codigo  = null;
   public $email  = null;
   public $estado  = null;
   public $session_id  = null;
   public $fecha_expiracion  = null;
   public $fecha_compra  = null;

   public function __construct( $data=array() ){
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

   public function insert($producto_id) {
      $fields = array("compra_id", "producto_id", "vendedor_id", "codigo", "email", "estado", "session_id", "fecha_expiracion", "fecha_compra");

      $result = ConnectionFactory::getFactory()->insert($this, "compra", $fields);
      return array("error" => $error, "id" => $id);
   }








}
 ?>
