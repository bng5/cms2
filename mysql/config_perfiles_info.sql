
CREATE TABLE `config_perfiles_info` (
  `perfil_id` tinyint(3) unsigned NOT NULL,
  `atributo_id` tinyint(3) unsigned NOT NULL,
  `orden` tinyint(3) unsigned default NULL,
  `por_omision` int(10) unsigned default NULL,
  `salida` tinyint(1) NOT NULL default '1',
  `superior` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`perfil_id`,`atributo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
