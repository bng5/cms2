
CREATE TABLE `boletines_suscriptores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(1024)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado_id` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `agregado` DATETIME  NOT NULL,
  `autorizado` DATETIME  DEFAULT NULL,
  PRIMARY KEY(`id`),
  INDEX `new_index`(`email`)
)
ENGINE = MYISAM;