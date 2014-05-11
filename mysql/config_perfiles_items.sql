
CREATE TABLE `config_perfiles_items` (
  `perfil_id` tinyint(3) unsigned NOT NULL,
  `atributo_id` int(10) unsigned NOT NULL,
  `orden` tinyint(3) unsigned default NULL,
  `por_omision` int(10) unsigned default NULL,
  `en_listado` tinyint(1) NOT NULL default '0',
  `salida` tinyint(1) NOT NULL default '1',
  `superior` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`perfil_id`,`atributo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
