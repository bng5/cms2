-- 2009-06-03
ALTER TABLE `archivos` CHANGE `formato` `formato` VARCHAR( 50 ) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL

-- 2009-05-29
ALTER TABLE `usuarios` ADD COLUMN `su` BOOL  NOT NULL DEFAULT 0 AFTER `admin`;

-- 2009-05-14
ALTER TABLE `usuarios` ADD COLUMN `leng_id` INTEGER UNSIGNED NOT NULL DEFAULT 76 AFTER `admin`;

-- 2009-05-19
ALTER TABLE `items_atributos` ADD COLUMN `formato` BOOL  NOT NULL DEFAULT 0 AFTER `et_xhtml_id`;

-- 2009-05-25
ALTER TABLE `items` ADD COLUMN `vistas` INTEGER UNSIGNED NOT NULL DEFAULT 0 AFTER `usuarioedicion`;
ALTER TABLE `items` MODIFY COLUMN `vistas` INT(2) UNSIGNED ZEROFILL NOT NULL DEFAULT 0;

