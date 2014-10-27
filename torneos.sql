-- MySQL dump 10.11
--
-- Host: localhost    Database: dxtev0_website
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activacion`
--

DROP TABLE IF EXISTS `activacion`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `activacion` (
  `act_id` int(11) NOT NULL auto_increment,
  `act_code` varchar(45) NOT NULL,
  `usua_id` int(2) NOT NULL,
  PRIMARY KEY  (`act_id`),
  KEY `act_usua_fk` (`usua_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `clubes`
--

DROP TABLE IF EXISTS `clubes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `clubes` (
  `club_id` int(11) NOT NULL auto_increment,
  `club_nombre` varchar(255) NOT NULL,
  `club_abreviatura` varchar(10) NOT NULL,
  PRIMARY KEY  (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `deportes`
--

DROP TABLE IF EXISTS `deportes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `deportes` (
  `depo_id` int(11) NOT NULL auto_increment,
  `depo_nombre` varchar(255) NOT NULL,
  `depo_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`depo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `draws`
--

DROP TABLE IF EXISTS `draws`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `draws` (
  `draw_id` int(11) NOT NULL auto_increment,
  `evmo_id` int(11) NOT NULL,
  `ronda_id` int(11) NOT NULL,
  `juga_id1` int(11) default NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) default NULL,
  `juga_id4` int(11) default NULL,
  `draw_ganador` int(1) default NULL,
  `draw_score` varchar(50) default NULL,
  `draw_fecha` datetime default NULL,
  PRIMARY KEY  (`draw_id`),
  KEY `ronda_fk` (`ronda_id`),
  KEY `jugador_fk1` (`juga_id1`),
  KEY `jugador_fk2` (`juga_id2`),
  KEY `jugador_fk3` (`juga_id3`),
  KEY `jugador_fk4` (`juga_id4`),
  CONSTRAINT `jugador_fk1` FOREIGN KEY (`juga_id1`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `jugador_fk2` FOREIGN KEY (`juga_id2`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `jugador_fk3` FOREIGN KEY (`juga_id3`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `jugador_fk4` FOREIGN KEY (`juga_id4`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ronda_fk` FOREIGN KEY (`ronda_id`) REFERENCES `rondas` (`ronda_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89040 DEFAULT CHARSET=latin1 COMMENT='Aquí se almacenan los draws con los resultados';
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `draws_log`
--

DROP TABLE IF EXISTS `draws_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `draws_log` (
  `juga_id1` int(11) default NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) default NULL,
  `juga_id4` int(11) default NULL,
  `draw_fecha` datetime default NULL,
  `draw_ganador` int(11) default NULL,
  `draw_score` tinytext,
  `evmo_id` int(11) default NULL,
  `ronda_id` int(11) default NULL,
  `error` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `draws_puntajes`
--

DROP TABLE IF EXISTS `draws_puntajes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `draws_puntajes` (
  `evmo_id` int(11) NOT NULL,
  `juga_id` int(11) NOT NULL,
  `draws_puntos` decimal(10,2) default NULL,
  PRIMARY KEY  (`evmo_id`,`juga_id`),
  KEY `jugador_ptos_fk` (`juga_id`),
  CONSTRAINT `jugador_ptos_fk` FOREIGN KEY (`juga_id`) REFERENCES `jugadores` (`juga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `draws_respaldo`
--

DROP TABLE IF EXISTS `draws_respaldo`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `draws_respaldo` (
  `draw_id` int(11) NOT NULL default '0',
  `evmo_id` int(11) NOT NULL,
  `ronda_id` int(11) NOT NULL,
  `juga_id1` int(11) default NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) default NULL,
  `juga_id4` int(11) default NULL,
  `draw_ganador` int(1) default NULL,
  `draw_score` varchar(50) default NULL,
  `draw_fecha` datetime default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `equipos` (
  `equipo_id` int(11) NOT NULL auto_increment,
  `equipo_nombre` varchar(50) NOT NULL,
  `club_id` int(11) NOT NULL,
  `inter_id` int(11) NOT NULL,
  `equipo_usuario` varchar(20) NOT NULL,
  `equipo_clave` varchar(20) NOT NULL,
  `equipo_email` varchar(255) NOT NULL,
  `equipo_puntos` decimal(10,2) NOT NULL default '0.00',
  `equipo_tipo_cancha` varchar(1) default NULL COMMENT 'C: Cemento, A: Arcilla, G: Grama',
  `equipo_fecha_insc` datetime NOT NULL,
  `equipo_estatus` varchar(1) NOT NULL default 'I' COMMENT 'El estatus puede ser I: inscrito por aprobar, A: aprobado, R: rechazado',
  `intergrup_id` int(11) default NULL,
  PRIMARY KEY  (`equipo_id`),
  KEY `equipo_club_fk` (`club_id`),
  KEY `equipo_inter_fk` (`inter_id`),
  KEY `equipo_grupo_fk` (`intergrup_id`),
  CONSTRAINT `equipo_club_fk` FOREIGN KEY (`club_id`) REFERENCES `clubes` (`club_id`),
  CONSTRAINT `equipo_grupo_fk` FOREIGN KEY (`intergrup_id`) REFERENCES `interclubes_grupos` (`intergrup_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `equipo_inter_fk` FOREIGN KEY (`inter_id`) REFERENCES `interclubes_categorias` (`inter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `equipos_jugadores`
--

DROP TABLE IF EXISTS `equipos_jugadores`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `equipos_jugadores` (
  `equipo_id` int(11) NOT NULL,
  `juga_id` int(11) NOT NULL,
  `eqju_rank_individual` int(10) unsigned NOT NULL default '1',
  `eqju_rank_doble` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`equipo_id`,`juga_id`),
  KEY `equipo_jugador_fk1` (`equipo_id`),
  KEY `equipo_jugador_fk2` (`juga_id`),
  CONSTRAINT `equipo_jugador_fk1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`equipo_id`),
  CONSTRAINT `equipo_jugador_fk2` FOREIGN KEY (`juga_id`) REFERENCES `jugadores` (`juga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `estados` (
  `edo_id` int(11) NOT NULL auto_increment,
  `edo_nombre` varchar(30) NOT NULL,
  PRIMARY KEY  (`edo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eventos` (
  `even_id` int(11) NOT NULL auto_increment,
  `depo_id` int(11) NOT NULL,
  `even_nombre` varchar(255) NOT NULL,
  `even_fecha` date NOT NULL default '0000-00-00',
  `even_sede` varchar(200) default NULL,
  `even_ciudad` varchar(200) NOT NULL,
  `even_afiche` varchar(255) default NULL,
  `even_publicarhome` varchar(1) NOT NULL default 'N',
  `even_archivo` varchar(255) default NULL,
  `even_publicar` varchar(1) NOT NULL default 'S',
  `even_cerrado` varchar(1) NOT NULL default 'N',
  PRIMARY KEY  (`even_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `eventos_modalidades`
--

DROP TABLE IF EXISTS `eventos_modalidades`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `eventos_modalidades` (
  `evmo_id` int(11) NOT NULL auto_increment,
  `even_id` int(11) NOT NULL,
  `moda_id` int(11) NOT NULL,
  `evmo_premiacion` varchar(100) NOT NULL,
  `evmo_subcampeon` varchar(100) default NULL,
  `evmo_fecha` date NOT NULL default '0000-00-00',
  `evmo_cerrado` varchar(1) NOT NULL default 'N',
  `evmo_publicar_draw` varchar(1) NOT NULL default 'N',
  `evmo_costo_inscripcion` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`evmo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galerias`
--

DROP TABLE IF EXISTS `galerias`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `galerias` (
  `gale_id` int(11) NOT NULL auto_increment,
  `depo_id` int(11) default NULL,
  `gale_nombre` varchar(255) NOT NULL,
  `gale_imagenpp` varchar(100) NOT NULL,
  `gale_fecha` date NOT NULL default '0000-00-00',
  `gale_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`gale_id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `galerias_fotos`
--

DROP TABLE IF EXISTS `galerias_fotos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `galerias_fotos` (
  `gafo_id` int(11) NOT NULL auto_increment,
  `gale_id` int(11) NOT NULL,
  `gafo_nombre` varchar(255) NOT NULL,
  `gafo_foto` varchar(100) NOT NULL,
  `gafo_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`gafo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `inscripciones_eventos`
--

DROP TABLE IF EXISTS `inscripciones_eventos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `inscripciones_eventos` (
  `evmo_id` int(11) NOT NULL,
  `juga_id1` int(11) NOT NULL,
  `juga_id2` int(11) default NULL,
  `inev_fecha_insc` datetime NOT NULL COMMENT 'Fecha de inscripcion al evento',
  `inev_estatus` varchar(1) NOT NULL COMMENT 'El estatus puede ser I: inscrito por aprobar, A: aprobado, R: rechazado',
  PRIMARY KEY  (`evmo_id`,`juga_id1`),
  UNIQUE KEY `juga_id2_uk` (`evmo_id`,`juga_id2`),
  KEY `juga_id1_fk` (`juga_id1`),
  KEY `juga_id2_fk` (`juga_id2`),
  CONSTRAINT `juga_id1_fk` FOREIGN KEY (`juga_id1`) REFERENCES `jugadores` (`juga_id`),
  CONSTRAINT `juga_id2_fk` FOREIGN KEY (`juga_id2`) REFERENCES `jugadores` (`juga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `inscripciones_pagos`
--

DROP TABLE IF EXISTS `inscripciones_pagos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `inscripciones_pagos` (
  `evmo_id` int(11) NOT NULL,
  `juga_id1` int(11) NOT NULL,
  `inpa_fecha` datetime default NULL,
  `inpa_monto1` decimal(10,2) NOT NULL default '0.00',
  `inpa_estatus1` varchar(1) NOT NULL default 'I' COMMENT 'I: Impaga,  P: Paga, E: En proceso de pago',
  `inpa_monto2` decimal(10,2) NOT NULL default '0.00',
  `inpa_estatus2` varchar(1) NOT NULL default 'N' COMMENT 'I: Impaga,  P: Paga, E: En proceso de pago, N: No aplica',
  `tran_id1` int(11) unsigned default NULL,
  `tran_id2` int(11) unsigned default NULL,
  PRIMARY KEY  (`evmo_id`,`juga_id1`),
  KEY `insc_pagos_fk` (`evmo_id`,`juga_id1`),
  CONSTRAINT `insc_pagos_fk` FOREIGN KEY (`evmo_id`, `juga_id1`) REFERENCES `inscripciones_eventos` (`evmo_id`, `juga_id1`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_categorias`
--

DROP TABLE IF EXISTS `interclubes_categorias`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_categorias` (
  `inter_id` int(11) NOT NULL auto_increment,
  `inter_nombre` varchar(50) NOT NULL,
  `inter_puntaje_jornada` int(11) NOT NULL COMMENT 'Puntos obtenidos al ganar una jornada',
  `inter_publicar` varchar(1) NOT NULL default 'S',
  `inter_cerrado` varchar(1) NOT NULL default 'N',
  `inter_fecha` date NOT NULL,
  `inter_afiche` varchar(255) default NULL,
  `inter_categoria` varchar(4) default NULL,
  `inter_tipo` varchar(1) NOT NULL COMMENT 'Tipo de interclubes',
  `inter_cant_equipos_x_grupo` int(10) unsigned NOT NULL default '0',
  `liga_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`inter_id`,`inter_nombre`,`inter_puntaje_jornada`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_draw`
--

DROP TABLE IF EXISTS `interclubes_draw`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_draw` (
  `interdraw_id` int(11) NOT NULL auto_increment,
  `inter_id` int(11) NOT NULL,
  `ronda_id` int(11) NOT NULL,
  `equipo_id1` int(11) default NULL,
  `equipo_id2` int(11) default NULL,
  `interdraw_ganador` int(1) default NULL,
  `interdraw_score` varchar(50) default NULL,
  `interdraw_fecha` datetime default NULL,
  PRIMARY KEY  (`interdraw_id`),
  KEY `interdraw_ronda_fk` (`ronda_id`),
  KEY `interclubes_draw_fk` (`inter_id`),
  KEY `fk_interclubes_draw_equipos1` (`equipo_id1`),
  KEY `fk_interclubes_draw_equipos2` (`equipo_id2`),
  CONSTRAINT `fk_interclubes_draw_equipos1` FOREIGN KEY (`equipo_id1`) REFERENCES `equipos` (`equipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_interclubes_draw_equipos2` FOREIGN KEY (`equipo_id2`) REFERENCES `equipos` (`equipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `interclubes_draw_fk` FOREIGN KEY (`inter_id`) REFERENCES `interclubes_categorias` (`inter_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `interdraw_ronda_fk` FOREIGN KEY (`ronda_id`) REFERENCES `rondas` (`ronda_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_draw_juegos`
--

DROP TABLE IF EXISTS `interclubes_draw_juegos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_draw_juegos` (
  `juego_id` int(11) NOT NULL,
  `interdraw_id` int(11) NOT NULL,
  `interconf_id` int(11) NOT NULL,
  `juga_id1` int(11) default NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) default NULL,
  `juga_id4` int(11) default NULL,
  `juego_ganador` int(11) default NULL,
  `juego_score` varchar(50) default NULL,
  `juego_fecha` datetime default NULL,
  PRIMARY KEY  (`juego_id`),
  KEY `fk_interclubes_draw_juegos_jugadores1` (`juga_id1`),
  KEY `fk_interclubes_draw_juegos_jugadores2` (`juga_id2`),
  KEY `fk_interclubes_draw_juegos_jugadores3` (`juga_id3`),
  KEY `fk_interclubes_draw_juegos_jugadores4` (`juga_id4`),
  KEY `interclubes_draw_juegos_fk` (`interdraw_id`),
  KEY `interclubes_draw_juegos_config_fk` (`interconf_id`),
  CONSTRAINT `fk_interclubes_draw_juegos_jugadores1` FOREIGN KEY (`juga_id1`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_interclubes_draw_juegos_jugadores2` FOREIGN KEY (`juga_id2`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_interclubes_draw_juegos_jugadores3` FOREIGN KEY (`juga_id3`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_interclubes_draw_juegos_jugadores4` FOREIGN KEY (`juga_id4`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `interclubes_draw_juegos_config_fk` FOREIGN KEY (`interconf_id`) REFERENCES `interclubes_juegos_config` (`interconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `interclubes_draw_juegos_fk` FOREIGN KEY (`interdraw_id`) REFERENCES `interclubes_draw` (`interdraw_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_grupos`
--

DROP TABLE IF EXISTS `interclubes_grupos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_grupos` (
  `intergrup_id` int(11) NOT NULL auto_increment,
  `intergrup_nombre` varchar(50) NOT NULL,
  `inter_id` int(11) NOT NULL,
  PRIMARY KEY  (`intergrup_id`),
  KEY `interclubes_grupos_fk` (`inter_id`),
  CONSTRAINT `interclubes_grupos_fk` FOREIGN KEY (`inter_id`) REFERENCES `interclubes` (`inter_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_juegos_config`
--

DROP TABLE IF EXISTS `interclubes_juegos_config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_juegos_config` (
  `interconf_id` int(11) NOT NULL auto_increment,
  `inter_id` int(11) NOT NULL,
  `interconf_sexo` varchar(2) NOT NULL COMMENT 'Masculino, femenino o mixto',
  `interconf_tipo` varchar(1) NOT NULL COMMENT 'Doble o Individual',
  `interconf_puntaje_juego` int(11) NOT NULL COMMENT 'Puntos obtenidos al ganar un juego',
  `interconf_categoria` varchar(4) default NULL,
  PRIMARY KEY  (`interconf_id`),
  KEY `interconf_fk` (`inter_id`),
  CONSTRAINT `interconf_fk` FOREIGN KEY (`inter_id`) REFERENCES `interclubes_categorias` (`inter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_liga`
--

DROP TABLE IF EXISTS `interclubes_liga`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_liga` (
  `liga_id` int(11) NOT NULL,
  `liga_nombre` varchar(50) NOT NULL,
  `liga_fecha` date default NULL,
  `liga_publicar` varchar(1) NOT NULL default 'S',
  `liga_cerrado` varchar(1) NOT NULL default 'N',
  `liga_afiche` varchar(255) default NULL,
  PRIMARY KEY  (`liga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `interclubes_patrocinantes`
--

DROP TABLE IF EXISTS `interclubes_patrocinantes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `interclubes_patrocinantes` (
  `liga_id` int(11) NOT NULL,
  `patr_id` int(11) NOT NULL,
  PRIMARY KEY  (`patr_id`,`liga_id`),
  KEY `fk_interclubes_patrocinantes_interclubes_liga1` (`liga_id`),
  CONSTRAINT `fk_interclubes_patrocinantes_interclubes_liga1` FOREIGN KEY (`liga_id`) REFERENCES `interclubes_liga` (`liga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `jornadas`
--

DROP TABLE IF EXISTS `jornadas`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jornadas` (
  `jorn_id` int(11) NOT NULL auto_increment,
  `inter_id` int(11) NOT NULL,
  `jorn_numero` int(11) NOT NULL COMMENT 'Numero de la jornada',
  `jorn_fecha` datetime default NULL COMMENT 'Fecha en la cual esta planificado el juego',
  `jorn_lugar` varchar(255) default NULL COMMENT 'Lugar donde se realizaran los juegos',
  `equipo_id1` int(11) default NULL,
  `equipo_id2` int(11) default NULL,
  `jorn_ganador` int(11) default NULL,
  `jorn_score` varchar(50) default NULL,
  `jorn_home` int(1) default NULL COMMENT 'Determina quien es home y quien es visitante con 1 o 2 dependiendo que equipo es home',
  `intergrup_id` int(11) default NULL,
  PRIMARY KEY  (`jorn_id`),
  KEY `jornada_interclub_fk` (`inter_id`),
  KEY `equipo1_fk` (`equipo_id1`),
  KEY `equipo2_fk` (`equipo_id2`),
  KEY `jornada_grupo_fk` (`intergrup_id`),
  CONSTRAINT `equipo1_fk` FOREIGN KEY (`equipo_id1`) REFERENCES `equipos` (`equipo_id`),
  CONSTRAINT `equipo2_fk` FOREIGN KEY (`equipo_id2`) REFERENCES `equipos` (`equipo_id`),
  CONSTRAINT `jornada_grupo_fk` FOREIGN KEY (`intergrup_id`) REFERENCES `interclubes_grupos` (`intergrup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `jornada_interclub_fk` FOREIGN KEY (`inter_id`) REFERENCES `interclubes_categorias` (`inter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `jornadas_juegos`
--

DROP TABLE IF EXISTS `jornadas_juegos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jornadas_juegos` (
  `juego_id` int(11) NOT NULL auto_increment,
  `jorn_id` int(11) NOT NULL,
  `interconf_id` int(11) NOT NULL,
  `juga_id1` int(11) default NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) default NULL,
  `juga_id4` int(11) default NULL,
  `juego_ganador` int(11) default NULL,
  `juego_score` varchar(50) default NULL,
  `juego_fecha` datetime default NULL,
  PRIMARY KEY  (`juego_id`),
  KEY `jornadas_juegos_fk` (`jorn_id`),
  KEY `juego_jugador1_fk` (`juga_id1`),
  KEY `juego_jugador2_fk` (`juga_id2`),
  KEY `juego_jugador3_fk` (`juga_id3`),
  KEY `juego_jugador4_fk` (`juga_id4`),
  KEY `fk_jornadas_juegos_interclubes_juegos_config1` (`interconf_id`),
  CONSTRAINT `fk_jornadas_juegos_interclubes_juegos_config1` FOREIGN KEY (`interconf_id`) REFERENCES `interclubes_juegos_config` (`interconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `jornadas_juegos_fk` FOREIGN KEY (`jorn_id`) REFERENCES `jornadas` (`jorn_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `juego_jugador1_fk` FOREIGN KEY (`juga_id1`) REFERENCES `jugadores` (`juga_id`),
  CONSTRAINT `juego_jugador2_fk` FOREIGN KEY (`juga_id2`) REFERENCES `jugadores` (`juga_id`),
  CONSTRAINT `juego_jugador3_fk` FOREIGN KEY (`juga_id3`) REFERENCES `jugadores` (`juga_id`),
  CONSTRAINT `juego_jugador4_fk` FOREIGN KEY (`juga_id4`) REFERENCES `jugadores` (`juga_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jugadores` (
  `juga_id` int(11) NOT NULL,
  `juga_nombre` varchar(100) NOT NULL,
  `juga_apellido` varchar(100) default NULL,
  `juga_fecha_nac` date default NULL,
  `juga_sexo` varchar(1) default NULL,
  `juga_ciudad` varchar(255) default NULL,
  `juga_zona` varchar(255) default NULL,
  `club_id` int(11) default NULL,
  `juga_email` varchar(255) default NULL,
  `juga_telf_hab` varchar(20) default NULL,
  `juga_telf_ofic` varchar(20) default NULL,
  `juga_telf_cel` varchar(20) default NULL,
  `juga_pin` varchar(10) default NULL,
  `juga_twitter` varchar(50) default NULL,
  `juga_facebook` varchar(50) default NULL,
  `juga_foto` varchar(100) default NULL,
  `edo_id` int(11) default NULL,
  `juga_otro_club` varchar(255) default NULL,
  `juga_categoria` varchar(10) default NULL,
  `juga_alias` varchar(45) default NULL,
  `juga_ficha_perfil` varchar(1) NOT NULL default '+',
  PRIMARY KEY  (`juga_id`),
  UNIQUE KEY `juga_email_uk` (`juga_email`),
  KEY `club_fk` (`club_id`),
  KEY `estado_fk` (`edo_id`),
  CONSTRAINT `club_fk` FOREIGN KEY (`club_id`) REFERENCES `clubes` (`club_id`),
  CONSTRAINT `estado_fk` FOREIGN KEY (`edo_id`) REFERENCES `estados` (`edo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `jugadores_log`
--

DROP TABLE IF EXISTS `jugadores_log`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jugadores_log` (
  `juga_id` double default NULL,
  `juga_nombre` tinytext,
  `juga_apellido` tinytext,
  `juga_fecha_nac` tinytext,
  `juga_sexo` char(1) default NULL,
  `juga_ciudad` tinytext,
  `juga_zona` tinytext,
  `juga_email` tinytext,
  `juga_telf_hab` tinytext,
  `juga_telf_ofic` tinytext,
  `juga_telf_cel` tinytext,
  `juga_pin` tinytext,
  `juga_twitter` tinytext,
  `juga_facebook` tinytext,
  `club_id` int(11) default NULL,
  `error` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `miscelaneos`
--

DROP TABLE IF EXISTS `miscelaneos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `miscelaneos` (
  `misc_id` int(11) NOT NULL auto_increment,
  `misc_variable` varchar(255) NOT NULL default '',
  `misc_titulo` varchar(255) NOT NULL,
  `misc_texto` text NOT NULL,
  `misc_imagen1` varchar(100) default NULL,
  PRIMARY KEY  (`misc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `modalidades`
--

DROP TABLE IF EXISTS `modalidades`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `modalidades` (
  `moda_id` int(11) NOT NULL auto_increment,
  `depo_id` int(11) NOT NULL,
  `moda_nombre` varchar(255) NOT NULL,
  `moda_abreviatura` varchar(5) NOT NULL,
  `moda_sexo` varchar(20) NOT NULL,
  `moda_publicar` varchar(1) NOT NULL default 'S',
  `moda_tipo` varchar(1) NOT NULL default 'D',
  PRIMARY KEY  (`moda_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `patrocinantes`
--

DROP TABLE IF EXISTS `patrocinantes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `patrocinantes` (
  `patr_id` int(11) NOT NULL auto_increment,
  `patr_nombre` varchar(100) NOT NULL,
  `patr_logo` varchar(100) NOT NULL,
  `patr_activo` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`patr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `patrocinantes_eventos`
--

DROP TABLE IF EXISTS `patrocinantes_eventos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `patrocinantes_eventos` (
  `prev_id` int(11) NOT NULL auto_increment,
  `even_id` int(11) NOT NULL,
  `patr_id` int(11) NOT NULL,
  `prev_orden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`prev_id`)
) ENGINE=MyISAM AUTO_INCREMENT=342 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `prensas`
--

DROP TABLE IF EXISTS `prensas`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `prensas` (
  `pren_id` int(11) NOT NULL auto_increment,
  `pren_fecha` date NOT NULL default '0000-00-00',
  `pren_titulo` varchar(255) NOT NULL,
  `pren_resumen` text NOT NULL,
  `pren_texto` text NOT NULL,
  `pren_imagen` varchar(100) NOT NULL,
  `pren_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`pren_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `publicidades`
--

DROP TABLE IF EXISTS `publicidades`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `publicidades` (
  `publ_id` int(11) NOT NULL auto_increment,
  `publ_nombre` varchar(255) NOT NULL,
  `publ_archivo` varchar(100) NOT NULL,
  `publ_ubicacion` varchar(20) NOT NULL default 'HORIZONTAL',
  `publ_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`publ_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `publicidades_secciones`
--

DROP TABLE IF EXISTS `publicidades_secciones`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `publicidades_secciones` (
  `publ_id` int(11) NOT NULL,
  `puse_seccion` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`publ_id`,`puse_seccion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rankings`
--

DROP TABLE IF EXISTS `rankings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rankings` (
  `rank_id` int(11) NOT NULL auto_increment,
  `depo_id` int(11) default NULL,
  `rank_nombre` varchar(255) NOT NULL,
  `rank_ano` int(4) NOT NULL,
  `rank_archivo` varchar(100) default NULL,
  `rank_imagen` varchar(100) default NULL,
  `rank_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`rank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rankings_fotos`
--

DROP TABLE IF EXISTS `rankings_fotos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rankings_fotos` (
  `rafo_id` int(11) NOT NULL auto_increment,
  `rank_id` int(11) NOT NULL,
  `rafo_descripcion` text,
  `rafo_foto` varchar(100) NOT NULL,
  `rafo_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`rafo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rankings_modalidades`
--

DROP TABLE IF EXISTS `rankings_modalidades`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rankings_modalidades` (
  `rank_id` int(11) NOT NULL,
  `moda_id` int(11) NOT NULL,
  PRIMARY KEY  (`rank_id`,`moda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rankings_posiciones`
--

DROP TABLE IF EXISTS `rankings_posiciones`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rankings_posiciones` (
  `rapo_id` int(11) NOT NULL auto_increment,
  `rank_id` int(11) NOT NULL,
  `rapo_jugador` varchar(100) NOT NULL,
  `rapo_puntos` decimal(15,2) NOT NULL,
  `rapo_tj` varchar(50) NOT NULL,
  `rapo_orden` int(11) NOT NULL default '0',
  `juga_id` int(11) default NULL,
  PRIMARY KEY  (`rapo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1488 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rating_categoria_config`
--

DROP TABLE IF EXISTS `rating_categoria_config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rating_categoria_config` (
  `racat_id` int(11) NOT NULL auto_increment,
  `raconf_id` int(11) NOT NULL,
  `raconf_puntos_min` decimal(10,2) NOT NULL,
  `raconf_puntos_max` decimal(10,2) NOT NULL,
  `raconf_categoria` varchar(4) NOT NULL,
  PRIMARY KEY  (`racat_id`),
  KEY `fk_rating_categoria_config_rating_config1` (`raconf_id`),
  CONSTRAINT `fk_rating_categoria_config_rating_config1` FOREIGN KEY (`raconf_id`) REFERENCES `rating_config` (`raconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rating_config`
--

DROP TABLE IF EXISTS `rating_config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rating_config` (
  `raconf_id` int(11) NOT NULL auto_increment,
  `raconf_factor_movilidad` decimal(10,2) NOT NULL,
  `raconf_factor_puntos` decimal(10,2) NOT NULL,
  `raconf_fecha_ult_corte` datetime default NULL,
  `raconf_publicar` varchar(1) NOT NULL default 'S',
  `raconf_nombre` varchar(255) NOT NULL,
  `raconf_sexo` varchar(2) NOT NULL,
  `raconf_tipo` varchar(1) NOT NULL,
  PRIMARY KEY  (`raconf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rating_juegos_hist`
--

DROP TABLE IF EXISTS `rating_juegos_hist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rating_juegos_hist` (
  `rajue_id` int(11) NOT NULL auto_increment,
  `rajue_fecha` datetime NOT NULL,
  `juga_id1` int(11) NOT NULL,
  `juga_id2` int(11) default NULL,
  `juga_id3` int(11) NOT NULL,
  `juga_id4` int(11) default NULL,
  `juga1_puntos_ant` decimal(10,2) NOT NULL,
  `juga2_puntos_ant` decimal(10,2) default NULL,
  `juga3_puntos_ant` decimal(10,2) NOT NULL,
  `juga4_puntos_ant` decimal(10,2) default NULL,
  `rajue_ganador` int(1) NOT NULL,
  `rajue_peso` decimal(10,2) NOT NULL,
  `rajue_esperado` decimal(10,2) NOT NULL COMMENT 'Porcentaje esperado de victoria',
  `rajue_ajuste` decimal(10,2) NOT NULL,
  `raconf_id` int(11) NOT NULL,
  `rajue_score` varchar(45) default NULL,
  `rajue_nombre_torneo` varchar(45) default NULL,
  `rajue_modalidad_torneo` varchar(45) default NULL,
  PRIMARY KEY  (`rajue_id`),
  KEY `rajue_jugador1_fk` (`juga_id1`),
  KEY `rajue_jugador2_fk` (`juga_id2`),
  KEY `fk_rating_juegos_hist_rating_config1` (`raconf_id`),
  KEY `rajue_jugador3_fk` (`juga_id3`),
  KEY `rajue_jugador4_fk` (`juga_id4`),
  CONSTRAINT `fk_rating_juegos_hist_rating_config1` FOREIGN KEY (`raconf_id`) REFERENCES `rating_config` (`raconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rajue_jugador1_fk` FOREIGN KEY (`juga_id1`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rajue_jugador2_fk` FOREIGN KEY (`juga_id2`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rajue_jugador3_fk` FOREIGN KEY (`juga_id3`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rajue_jugador4_fk` FOREIGN KEY (`juga_id4`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2494 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rating_jugadores_hist`
--

DROP TABLE IF EXISTS `rating_jugadores_hist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rating_jugadores_hist` (
  `juga_id` int(11) NOT NULL,
  `raju_fecha_corte` datetime NOT NULL,
  `raju_puntos` decimal(10,2) NOT NULL default '0.00',
  `raconf_id` int(11) NOT NULL,
  PRIMARY KEY  (`juga_id`,`raju_fecha_corte`),
  KEY `fk_rating_jugadores_jugadores1` (`juga_id`),
  KEY `fk_rating_jugadores_hist_rating_config1` (`raconf_id`),
  CONSTRAINT `fk_rating_jugadores_hist_rating_config1` FOREIGN KEY (`raconf_id`) REFERENCES `rating_config` (`raconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_jugadores_jugadores1` FOREIGN KEY (`juga_id`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rating_pesos_config`
--

DROP TABLE IF EXISTS `rating_pesos_config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rating_pesos_config` (
  `rapes_id` int(11) NOT NULL auto_increment,
  `raconf_id` int(11) NOT NULL,
  `raconf_nombre` varchar(45) default NULL,
  `raconf_peso` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`rapes_id`),
  KEY `fk_rating_config_pesos_rating_config1` (`raconf_id`),
  CONSTRAINT `fk_rating_config_pesos_rating_config1` FOREIGN KEY (`raconf_id`) REFERENCES `rating_config` (`raconf_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rondas`
--

DROP TABLE IF EXISTS `rondas`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rondas` (
  `ronda_id` int(11) NOT NULL auto_increment,
  `ronda_nombre` varchar(20) NOT NULL,
  `ronda_draws` int(11) NOT NULL,
  `ronda_puntos` decimal(10,2) default NULL,
  PRIMARY KEY  (`ronda_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `transacciones_pagos`
--

DROP TABLE IF EXISTS `transacciones_pagos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `transacciones_pagos` (
  `tran_id` int(11) NOT NULL auto_increment,
  `tran_fecha` datetime NOT NULL,
  `tran_concepto` varchar(255) NOT NULL,
  `tran_monto` decimal(10,2) NOT NULL,
  `tran_estatus` varchar(1) NOT NULL default 'I' COMMENT 'I: Impaga, P: Paga',
  `juga_id` int(11) default NULL,
  PRIMARY KEY  (`tran_id`),
  KEY `tran_juga_fk` (`juga_id`),
  CONSTRAINT `tran_juga_fk` FOREIGN KEY (`juga_id`) REFERENCES `jugadores` (`juga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `usuarios` (
  `usua_id` int(2) NOT NULL auto_increment,
  `usua_nombre` varchar(255) NOT NULL,
  `usua_email` varchar(255) NOT NULL,
  `usua_telefono` varchar(20) default NULL,
  `usua_clave` varchar(20) NOT NULL,
  `usua_tipo` varchar(20) NOT NULL,
  UNIQUE KEY `usua_id` (`usua_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1081 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `videos` (
  `vide_id` int(11) NOT NULL auto_increment,
  `depo_id` int(11) default NULL,
  `vide_nombre` varchar(255) NOT NULL,
  `vide_fecha` date NOT NULL default '0000-00-00',
  `vide_codigo` text NOT NULL,
  `vide_publicar` varchar(1) NOT NULL default 'S',
  PRIMARY KEY  (`vide_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-27  3:59:43
