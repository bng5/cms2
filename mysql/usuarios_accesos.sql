
DROP TABLE IF EXISTS `usuarios_accesos`;
CREATE TABLE  `usuarios_accesos` (
  `usuario_id` int(11) NOT NULL,
  `sesion_id` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `uri` varchar(150) NOT NULL,
  `tiempo` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=ascii;

