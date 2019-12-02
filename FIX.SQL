CREATE TABLE `compra` (
  `compra_id` INT NOT NULL AUTO_INCREMENT,
  `producto_id` INT NULL,
  `vendedor_id` INT NULL,
  `codigo` VARCHAR(45) NULL,
  `email` VARCHAR(255) NULL,
  `estado` TINYINT NULL,
  `session_id` VARCHAR(255) NULL,
  `fecha_expiracion` TIMESTAMP NULL,
  `fecha_compra` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`compra_id`));
