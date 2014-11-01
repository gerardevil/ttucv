CREATE TABLE `grupos` (
  `grupo_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_nombre` VARCHAR(45) NOT NULL,
  `evmo_id` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`grupo_id`)
)
ENGINE = InnoDB;


CREATE TABLE `grupos_jugadores` (
  `grju_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` INTEGER UNSIGNED NOT NULL,
  `juga_id1` INTEGER UNSIGNED,
  `juga_id2` INTEGER UNSIGNED,
  `grju_puntos` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`grju_id`)
)
ENGINE = InnoDB;

ALTER TABLE `grupos_jugadores` ADD CONSTRAINT `FK_grupos_jugadores_1` FOREIGN KEY `FK_grupos_jugadores_1` (`grupo_id`)
    REFERENCES `grupos` (`grupo_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;


CREATE TABLE `grupos_juegos` (
  `juego_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` INTEGER UNSIGNED NOT NULL,
  `grju_id1` INTEGER UNSIGNED,
  `grju_id2` INTEGER UNSIGNED,
  `juego_ganador` INTEGER UNSIGNED,
  `juego_score` VARCHAR(45),
  PRIMARY KEY (`juego_id`),
  CONSTRAINT `FK_grupos_juegos_1` FOREIGN KEY `FK_grupos_juegos_1` (`grupo_id`)
    REFERENCES `grupos` (`grupo_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grupos_juegos_2` FOREIGN KEY `FK_grupos_juegos_2` (`grju_id1`)
    REFERENCES `grupos_jugadores` (`grju_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `FK_grupos_juegos_3` FOREIGN KEY `FK_grupos_juegos_3` (`grju_id2`)
    REFERENCES `grupos_jugadores` (`grju_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB;



