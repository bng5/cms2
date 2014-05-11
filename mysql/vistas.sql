
DROP TABLE IF EXISTS `vistas`;
CREATE TABLE  `vistas` (
  `identificador` varchar(10) NOT NULL,
  `consulta` mediumtext NOT NULL,
  PRIMARY KEY  (`identificador`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii;

