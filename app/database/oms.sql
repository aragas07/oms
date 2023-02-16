-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema oms
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema oms
-- -----------------------------------------------------

drop schema oms;
CREATE SCHEMA IF NOT EXISTS `oms` DEFAULT CHARACTER SET utf8mb4 ;
USE `oms` ;

-- -----------------------------------------------------
-- Table `oms`.`municipality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`municipality` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `img` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`activities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`activities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `activity` VARCHAR(255) NULL DEFAULT NULL,
  `location` LONGTEXT NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `team_status` TINYINT(1) NULL DEFAULT NULL,
  `summary` LONGTEXT NULL DEFAULT NULL,
  `image` LONGTEXT NULL DEFAULT NULL,
  `municipality_id` INT(11) NOT NULL,
  `status` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_activities_municipality1_idx` (`municipality_id` ASC),
  CONSTRAINT `fk_activities_municipality1`
    FOREIGN KEY (`municipality_id`)
    REFERENCES `oms`.`municipality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`team` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `municipality_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_team_municipality1_idx` (`municipality_id` ASC),
  CONSTRAINT `fk_team_municipality1`
    FOREIGN KEY (`municipality_id`)
    REFERENCES `oms`.`municipality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 30
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` LONGTEXT NOT NULL,
  `firstname` VARCHAR(50) NOT NULL,
  `middlename` VARCHAR(50) NULL DEFAULT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `usertype` VARCHAR(10) NULL DEFAULT NULL,
  `team_id` INT(11) NULL DEFAULT NULL,
  `municipality_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_team1_idx` (`team_id` ASC),
  INDEX `fk_users_municipality1_idx` (`municipality_id` ASC),
  CONSTRAINT `fk_users_municipality1`
    FOREIGN KEY (`municipality_id`)
    REFERENCES `oms`.`municipality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_team1`
    FOREIGN KEY (`team_id`)
    REFERENCES `oms`.`team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`logs` (
  `users_id` INT(11) NOT NULL,
  `date` DATE NULL DEFAULT NULL,
  `status` TINYINT(4) NULL DEFAULT NULL,
  `assignment` LONGTEXT NULL,
  `timein` TIME NULL,
  `timeout` TIME NULL,
  INDEX `fk_logs_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_logs_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `oms`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`responded_personnel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`responded_personnel` (
  `users_id` INT(11) NULL DEFAULT NULL,
  `activities_id` INT(11) NULL DEFAULT NULL,
  INDEX `fk_table1_users_idx` (`users_id` ASC),
  INDEX `fk_table1_activities1_idx` (`activities_id` ASC),
  CONSTRAINT `fk_table1_activities1`
    FOREIGN KEY (`activities_id`)
    REFERENCES `oms`.`activities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `oms`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`responded_team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`responded_team` (
  `activities_id` INT(11) NOT NULL,
  `team_id` INT(11) NOT NULL,
  INDEX `fk_activities_has_team_team1_idx` (`team_id` ASC),
  INDEX `fk_activities_has_team_activities1_idx` (`activities_id` ASC),
  CONSTRAINT `fk_activities_has_team_activities1`
    FOREIGN KEY (`activities_id`)
    REFERENCES `oms`.`activities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_activities_has_team_team1`
    FOREIGN KEY (`team_id`)
    REFERENCES `oms`.`team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `oms`.`vehicle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oms`.`vehicle` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `vehicle` VARCHAR(45) NULL DEFAULT NULL,
  `type` VARCHAR(45) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT NULL,
  `municipality_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_vehicle_municipality1_idx` (`municipality_id` ASC),
  CONSTRAINT `fk_vehicle_municipality1`
    FOREIGN KEY (`municipality_id`)
    REFERENCES `oms`.`municipality` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
