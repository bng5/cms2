

CREATE TABLE `usuarios_atributos` (
  `id` tinyint(4) NOT NULL auto_increment,
  `orden` tinyint(4) unsigned NOT NULL default '0',
  `sugerido` tinyint(1) NOT NULL default '0',
  `unico` tinyint(1) NOT NULL default '0',
  `tipo` enum('string','date','text','int') character set ascii NOT NULL,
  `subtipo` tinyint(2) unsigned default NULL,
  `identificador` varchar(15) character set ascii NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='(string)(1)=color,(string)(2)=password,(date)(1)=fecha'

