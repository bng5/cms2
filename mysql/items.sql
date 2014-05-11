
DROP TABLE IF EXISTS `items`;
CREATE TABLE  `items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `seccion_id` int(10) unsigned NOT NULL,
  `estado_id` tinyint(3) unsigned NOT NULL default '0',
  `orden` int(10) unsigned default NULL,
  `f_creado` datetime NOT NULL,
  `f_modificado` datetime default NULL,
  `propietario` int(10) unsigned default NULL,
  `bloqueado` tinyint(3) unsigned NOT NULL default '0',
  `tiempoedicion` datetime default NULL,
  `uidedicion` char(24) default NULL,
  `usuarioedicion` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

