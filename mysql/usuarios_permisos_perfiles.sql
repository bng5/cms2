
DROP TABLE IF EXISTS `usuarios_permisos_perfiles`;
CREATE TABLE  `usuarios_permisos_perfiles` (
  `perfil_id` int(10) unsigned NOT NULL,
  `area_id` tinyint(3) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `permiso_id` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`perfil_id`,`area_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii ROW_FORMAT=FIXED;

