SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `estimulos` ;
USE `estimulos` ;

-- -----------------------------------------------------
-- Table `estimulos`.`evaluacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`evaluacion` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`evaluacion` (
  `anio` YEAR NOT NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `fecha_captura` DATE NULL ,
  `fecha_limite_captura` DATE NULL ,
  `fecha_evaluacion` DATE NULL ,
  `fecha_limite_evaluacion` DATE NULL ,
  PRIMARY KEY (`anio`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`categoria` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`categoria` (
  `id_categoria` INT NOT NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`id_categoria`) ,
  INDEX `index_anio1` (`anio` ASC) ,
  CONSTRAINT `fk_anio1`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`indicador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`indicador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`indicador` (
  `id_indicador` INT NOT NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`id_indicador`) ,
  INDEX `index_anio2` (`anio` ASC) ,
  CONSTRAINT `fk_anio2`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`categoria_indicador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`categoria_indicador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`categoria_indicador` (
  `id_categoriaindicador` INT NOT NULL ,
  `id_indicador` INT NULL ,
  `id_categoria` INT NULL ,
  INDEX `fk_categoria` (`id_categoria` ASC) ,
  INDEX `fk_indicador` (`id_indicador` ASC) ,
  PRIMARY KEY (`id_categoriaindicador`) ,
  CONSTRAINT `fk_categoria`
    FOREIGN KEY (`id_categoria` )
    REFERENCES `estimulos`.`categoria` (`id_categoria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_indicador`
    FOREIGN KEY (`id_indicador` )
    REFERENCES `estimulos`.`indicador` (`id_indicador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`porcentaje_indicador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`porcentaje_indicador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`porcentaje_indicador` (
  `id_porcentajeindicador` INT NOT NULL ,
  `id_categoriaindicador` INT NULL ,
  `porcentaje` INT NULL ,
  `descripción` VARCHAR(45) NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`id_porcentajeindicador`) ,
  INDEX `index_categoriaindicador` (`id_categoriaindicador` ASC) ,
  INDEX `index_anio4` (`anio` ASC) ,
  CONSTRAINT `fk_categoriaindicador`
    FOREIGN KEY (`id_categoriaindicador` )
    REFERENCES `estimulos`.`categoria_indicador` (`id_categoriaindicador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anio4`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`asignacion_indicador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`asignacion_indicador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`asignacion_indicador` (
  `id_asignacionindicador` INT NOT NULL ,
  `id_categoriaindicador` INT NULL ,
  `RFC_evaluador` VARCHAR(45) NULL ,
  `fecha` DATE NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`id_asignacionindicador`) ,
  INDEX `index_catindicador` (`id_categoriaindicador` ASC) ,
  INDEX `index_anio5` (`anio` ASC) ,
  CONSTRAINT `fk_catindicador`
    FOREIGN KEY (`id_categoriaindicador` )
    REFERENCES `estimulos`.`categoria_indicador` (`id_categoriaindicador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anio5`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`modificaciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`modificaciones` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`modificaciones` (
  `RFC` VARCHAR(45) NULL ,
  `anio` YEAR NULL ,
  INDEX `index_anio7` (`anio` ASC) ,
  CONSTRAINT `fk_anio7`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`evaluador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`evaluador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`evaluador` (
  `RFC_evaluador` VARCHAR(10) NOT NULL ,
  `nombre` VARCHAR(20) NULL ,
  `tipo` VARCHAR(10) NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`RFC_evaluador`) ,
  INDEX `index_anio6` (`anio` ASC) ,
  CONSTRAINT `fk_anio6`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estimulos`.`evaluacion_indicador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estimulos`.`evaluacion_indicador` ;

CREATE  TABLE IF NOT EXISTS `estimulos`.`evaluacion_indicador` (
  `id_evaluacionindicador` INT NOT NULL ,
  `id_categoriaindicador` INT NULL ,
  `RFC_empleado` VARCHAR(10) NULL ,
  `id_porcentajeindicador` INT NULL ,
  `cal_porcentaje` INT NULL ,
  `RFC_evaluador` VARCHAR(10) NULL ,
  `estado` VARCHAR(15) NULL ,
  `motivo` VARCHAR(255) NULL ,
  `anio` YEAR NULL ,
  PRIMARY KEY (`id_evaluacionindicador`) ,
  INDEX `index_categoriaindicad` (`id_categoriaindicador` ASC) ,
  INDEX `index_porcentaje` (`id_porcentajeindicador` ASC) ,
  INDEX `index_anio3` (`anio` ASC) ,
  INDEX `index_evaluadorr` (`RFC_evaluador` ASC) ,
  CONSTRAINT `fk_categoriaind`
    FOREIGN KEY (`id_categoriaindicador` )
    REFERENCES `estimulos`.`categoria_indicador` (`id_categoriaindicador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_porcentaje`
    FOREIGN KEY (`id_porcentajeindicador` )
    REFERENCES `estimulos`.`porcentaje_indicador` (`id_porcentajeindicador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_anio3`
    FOREIGN KEY (`anio` )
    REFERENCES `estimulos`.`evaluacion` (`anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluador`
    FOREIGN KEY (`RFC_evaluador` )
    REFERENCES `estimulos`.`evaluador` (`RFC_evaluador` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
