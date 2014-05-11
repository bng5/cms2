
DROP TABLE IF EXISTS `lenguajes`;
CREATE TABLE  `lenguajes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `superior` int(10) unsigned default '0',
  `dir` enum('ltr','rtl') NOT NULL,
  `leng_poromision` tinyint(3) unsigned default NULL,
  `estado` tinyint(3) unsigned NOT NULL default '0',
  `nombre_nativo` varchar(30) default NULL,
  PRIMARY KEY  (`id`),
  KEY `ind_cod` (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lenguajes`
--

/*!40000 ALTER TABLE `lenguajes` DISABLE KEYS */;
LOCK TABLES `lenguajes` WRITE;
INSERT INTO `lenguajes` VALUES  (1,'af',0,'ltr',NULL,0,'Afrikaans'),
 (2,'sq',0,'ltr',NULL,0,'Shqip'),
 (3,'de-de',5,'ltr',NULL,0,NULL),
 (4,'de-at',5,'ltr',NULL,0,NULL),
 (5,'de',0,'ltr',NULL,0,'Deutsch'),
 (6,'de-li',5,'ltr',NULL,0,NULL),
 (7,'de-lu',5,'ltr',NULL,0,NULL),
 (8,'de-ch',5,'ltr',NULL,0,NULL),
 (9,'am',0,'ltr',NULL,0,'አማርኛ'),
 (10,'ar',0,'rtl',NULL,0,'العربية'),
 (11,'ar-sa',10,'ltr',NULL,0,NULL),
 (12,'ar-dz',10,'ltr',NULL,0,NULL),
 (13,'ar-bh',10,'ltr',NULL,0,NULL),
 (14,'ar-eg',10,'ltr',NULL,0,NULL),
 (15,'ar-iq',10,'ltr',NULL,0,NULL),
 (16,'ar-jo',10,'ltr',NULL,0,NULL),
 (17,'ar-kw',10,'ltr',NULL,0,NULL),
 (18,'ar-lb',10,'ltr',NULL,0,NULL),
 (19,'ar-ly',10,'ltr',NULL,0,NULL),
 (20,'ar-ma',10,'ltr',NULL,0,NULL),
 (21,'ar-om',10,'ltr',NULL,0,NULL),
 (22,'ar-qa',10,'ltr',NULL,0,NULL),
 (23,'ar-sy',10,'ltr',NULL,0,NULL),
 (24,'ar-tn',10,'ltr',NULL,0,NULL),
 (25,'ar-ae',10,'ltr',NULL,0,NULL),
 (26,'ar-ye',10,'ltr',NULL,0,NULL),
 (27,'an',0,'ltr',NULL,0,'Aragonés'),
 (28,'hy',0,'ltr',NULL,0,'Հայերեն');
INSERT INTO `lenguajes` VALUES  (29,'as',0,'ltr',NULL,0,NULL),
 (30,'ast',0,'ltr',NULL,0,'Asturianu'),
 (31,'az',0,'ltr',NULL,0,'Azərbaycanca'),
 (32,'bn',0,'ltr',NULL,0,NULL),
 (33,'be',0,'ltr',NULL,0,'Беларуская'),
 (34,'bs',0,'ltr',NULL,0,'Bosanski'),
 (35,'br',0,'ltr',NULL,0,NULL),
 (36,'bg',0,'ltr',NULL,0,'Български'),
 (37,'my',0,'ltr',NULL,0,NULL),
 (38,'km',0,'ltr',NULL,0,NULL),
 (39,'ca',0,'ltr',NULL,0,'Català'),
 (40,'ch',0,'ltr',NULL,0,NULL),
 (41,'ce',0,'ltr',NULL,0,NULL),
 (42,'cs',0,'ltr',NULL,0,'Česky'),
 (43,'zh-cn',47,'ltr',NULL,0,NULL),
 (44,'zh-hk',47,'ltr',NULL,0,NULL),
 (45,'zh-sg',47,'ltr',NULL,0,NULL),
 (46,'zh-tw',47,'ltr',NULL,0,NULL),
 (47,'zh',0,'ltr',NULL,0,'中文'),
 (48,'cv',0,'ltr',NULL,0,NULL),
 (49,'ko-kp',51,'ltr',NULL,0,NULL),
 (50,'ko-kr',51,'ltr',NULL,0,NULL),
 (51,'ko',0,'ltr',NULL,0,'한국어'),
 (52,'co',0,'ltr',NULL,0,NULL),
 (53,'cr',0,'ltr',NULL,0,NULL),
 (54,'hr',0,'ltr',NULL,0,'Hrvatski'),
 (55,'da',0,'ltr',NULL,0,'Dansk'),
 (56,'sk',0,'ltr',NULL,0,'Slovenčina');
INSERT INTO `lenguajes` VALUES  (57,'sl',0,'ltr',NULL,0,'Slovenščina'),
 (58,'es-ar',65,'ltr',NULL,1,'Español Argentina'),
 (59,'es-bo',65,'ltr',NULL,0,NULL),
 (60,'es-cl',65,'ltr',NULL,0,NULL),
 (61,'es-co',65,'ltr',NULL,0,NULL),
 (62,'es-cr',65,'ltr',NULL,0,NULL),
 (63,'es-ec',65,'ltr',NULL,0,NULL),
 (64,'es-sv',65,'ltr',NULL,0,NULL),
 (65,'es',0,'ltr',NULL,0,'Español'),
 (66,'es-es',65,'ltr',NULL,0,'Español España'),
 (67,'es-gt',65,'ltr',NULL,0,NULL),
 (68,'es-hn',65,'ltr',NULL,0,NULL),
 (69,'es-mx',65,'ltr',NULL,0,NULL),
 (70,'es-ni',65,'ltr',NULL,0,NULL),
 (71,'es-pa',65,'ltr',NULL,0,NULL),
 (72,'es-py',65,'ltr',NULL,0,NULL),
 (73,'es-pe',65,'ltr',NULL,0,NULL),
 (74,'es-pr',65,'ltr',NULL,0,NULL),
 (75,'es-do',65,'ltr',NULL,0,NULL),
 (76,'es-uy',65,'ltr',NULL,0,'Español Uruguay'),
 (77,'es-ve',65,'ltr',NULL,0,NULL),
 (78,'eo',0,'ltr',NULL,0,'Esperanto'),
 (79,'et',0,'ltr',NULL,0,'Eesti'),
 (80,'fo',0,'ltr',NULL,0,NULL),
 (81,'fa',0,'rtl',NULL,0,'فارسی'),
 (82,'fj',0,'ltr',NULL,0,NULL);
INSERT INTO `lenguajes` VALUES  (83,'fi',0,'ltr',NULL,0,'Suomi'),
 (84,'fr-be',86,'ltr',NULL,0,NULL),
 (85,'fr-ca',86,'ltr',NULL,0,'français canadien'),
 (86,'fr',0,'ltr',NULL,0,'Français'),
 (87,'fr-fr',86,'ltr',NULL,0,NULL),
 (88,'fr-lu',86,'ltr',NULL,0,NULL),
 (89,'fr-mc',86,'ltr',NULL,0,NULL),
 (90,'fr-ch',86,'ltr',NULL,0,NULL),
 (91,'fy',0,'ltr',NULL,0,NULL),
 (92,'gl',0,'ltr',NULL,0,'Galego'),
 (93,'ka',0,'ltr',NULL,0,'ქართული'),
 (94,'el',0,'ltr',NULL,0,'Ελληνικά'),
 (95,'gu',0,'ltr',NULL,0,NULL),
 (96,'ht',0,'ltr',NULL,0,NULL),
 (97,'he',0,'rtl',NULL,0,'עברית'),
 (98,'hi',0,'ltr',NULL,0,'हिन्दी'),
 (99,'nl-be',100,'ltr',NULL,0,NULL),
 (100,'nl',0,'ltr',NULL,0,'Nederlands'),
 (101,'hu',0,'ltr',NULL,0,'Magyar'),
 (102,'id',0,'ltr',NULL,0,'Bahasa Indonesia'),
 (103,'en-au',106,'ltr',NULL,0,NULL),
 (104,'en-bz',106,'ltr',NULL,0,NULL),
 (105,'en-ca',106,'ltr',NULL,0,NULL),
 (106,'en',0,'ltr',NULL,0,'English'),
 (107,'en-us',106,'ltr',NULL,1,'English US'),
 (108,'en-ph',106,'ltr',NULL,0,NULL);
INSERT INTO `lenguajes` VALUES  (109,'en-ie',106,'ltr',NULL,0,NULL),
 (110,'en-jm',106,'ltr',NULL,0,NULL),
 (111,'en-nz',106,'ltr',NULL,0,NULL),
 (112,'en-gb',106,'ltr',NULL,0,'English UK'),
 (113,'en-za',106,'ltr',NULL,0,NULL),
 (114,'en-tt',106,'ltr',NULL,0,NULL),
 (115,'en-zw',106,'ltr',NULL,0,NULL),
 (116,'ia',0,'ltr',NULL,0,'Interlingua'),
 (117,'ie',0,'ltr',NULL,0,NULL),
 (118,'iu',0,'ltr',NULL,0,NULL),
 (119,'ga',0,'ltr',NULL,0,'Gaeilge'),
 (120,'is',0,'ltr',NULL,0,'Íslenska'),
 (121,'it',0,'ltr',NULL,0,'Italiano'),
 (122,'it-ch',121,'ltr',NULL,0,NULL),
 (123,'ja',0,'ltr',NULL,0,'日本語'),
 (124,'kn',0,'ltr',NULL,0,'ಕನ್ನಡ'),
 (125,'ks',0,'ltr',NULL,0,NULL),
 (126,'kk',0,'ltr',NULL,0,'Қазақ'),
 (127,'ky',0,'ltr',NULL,0,'Кыргыз'),
 (128,'tlh',0,'ltr',NULL,0,NULL),
 (129,'la',0,'ltr',NULL,0,'Latina'),
 (130,'lv',0,'ltr',NULL,0,'Latviešu'),
 (131,'lt',0,'ltr',NULL,0,'Lietuvių'),
 (132,'lb',0,'ltr',NULL,0,NULL),
 (133,'mk',0,'ltr',NULL,0,'Македонски'),
 (134,'ml',0,'ltr',NULL,0,NULL);
INSERT INTO `lenguajes` VALUES  (135,'ms',0,'ltr',NULL,0,'Bahasa Melayu'),
 (136,'mt',0,'ltr',NULL,0,'Malti'),
 (137,'mi',0,'ltr',NULL,0,NULL),
 (138,'mr',0,'ltr',NULL,0,NULL),
 (139,'mo',0,'ltr',NULL,0,NULL),
 (140,'nv',0,'ltr',NULL,0,NULL),
 (141,'ng',0,'ltr',NULL,0,NULL),
 (142,'ne',0,'ltr',NULL,0,NULL),
 (143,'nb',0,'ltr',NULL,0,NULL),
 (144,'no',0,'ltr',NULL,0,'Norsk'),
 (145,'nn',0,'ltr',NULL,0,NULL),
 (146,'oc',0,'ltr',NULL,0,NULL),
 (147,'or',0,'ltr',NULL,0,NULL),
 (148,'om',0,'ltr',NULL,0,NULL),
 (149,'pl',0,'ltr',NULL,0,'Polski'),
 (150,'pt-br',151,'ltr',NULL,0,'português brasileiro'),
 (151,'pt',0,'ltr',NULL,0,'Português'),
 (152,'pa-in',153,'ltr',NULL,0,NULL),
 (153,'pa',0,'ltr',NULL,0,NULL),
 (154,'pa-pk',153,'ltr',NULL,0,NULL),
 (155,'qu',0,'ltr',NULL,0,NULL),
 (156,'rm',0,'ltr',NULL,0,NULL),
 (157,'ro',0,'ltr',NULL,0,'Română'),
 (158,'ru',0,'ltr',NULL,0,'Русский'),
 (159,'sg',0,'ltr',NULL,0,NULL),
 (160,'sa',0,'ltr',NULL,0,NULL),
 (161,'sc',0,'ltr',NULL,0,NULL),
 (162,'gd',0,'ltr',NULL,0,NULL);
INSERT INTO `lenguajes` VALUES  (163,'sr',0,'ltr',NULL,0,'Srpski Српски'),
 (164,'sd',0,'ltr',NULL,0,NULL),
 (165,'si',0,'ltr',NULL,0,NULL),
 (166,'so',0,'ltr',NULL,0,'Somali'),
 (167,'sv-fi',168,'ltr',NULL,0,NULL),
 (168,'sv',0,'ltr',NULL,0,'Svenska'),
 (169,'sw',0,'ltr',NULL,0,'Kiswahili'),
 (170,'th',0,'ltr',NULL,0,'ภาษาไทย'),
 (171,'ta',0,'ltr',NULL,0,NULL),
 (172,'tt',0,'ltr',NULL,0,'Tatarça'),
 (173,'te',0,'ltr',NULL,0,'తెలుగు'),
 (174,'tig',0,'ltr',NULL,0,NULL),
 (175,'tr',0,'ltr',NULL,0,'Türkçe'),
 (176,'tk',0,'ltr',NULL,0,NULL),
 (177,'uk',0,'ltr',NULL,0,'Українська'),
 (178,'hsb',0,'ltr',NULL,0,NULL),
 (179,'eu',0,'ltr',1,0,'Euskara'),
 (180,'ve',0,'ltr',NULL,0,NULL),
 (181,'vi',0,'ltr',NULL,0,'Tiếng Việt'),
 (182,'vo',0,'ltr',NULL,0,NULL),
 (183,'wa',0,'ltr',NULL,0,NULL),
 (184,'cy',0,'ltr',NULL,0,'Cymraeg'),
 (185,'xh',0,'ltr',NULL,0,NULL),
 (186,'yi',0,'ltr',NULL,0,NULL),
 (187,'zu',0,'ltr',NULL,0,'isiZulu'),
 (188,'mk-mk',133,'ltr',NULL,0,'Македонски');
UNLOCK TABLES;
/*!40000 ALTER TABLE `lenguajes` ENABLE KEYS */;