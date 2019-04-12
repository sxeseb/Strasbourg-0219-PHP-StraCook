-- MySQL Script generated by MySQL Workbench
-- Fri Apr 12 09:46:37 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema strascook
-- -----------------------------------------------------
-- Base de données du site web StrasCook ! 

-- -----------------------------------------------------
-- Schema strascook
--
-- Base de données du site web StrasCook ! 
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `strascook` DEFAULT CHARACTER SET utf8 ;
USE `strascook` ;

-- -----------------------------------------------------
-- Table `strascook`.`price`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`price` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `price` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `img_src` VARCHAR(255) NULL,
  `thumb` TINYINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`menus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`menus` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` TEXT NULL,
  `starter` TEXT NULL,
  `main_course` TEXT NULL,
  `dessert` TEXT NULL,
  `description` TEXT NULL,
  `price_id` INT NOT NULL,
  `images_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_menus_price`
    FOREIGN KEY (`price_id`)
    REFERENCES `strascook`.`price` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_menus_images1`
    FOREIGN KEY (`images_id`)
    REFERENCES `strascook`.`images` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `adress` VARCHAR(255) NULL,
  `phone` VARCHAR(12) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`reservation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status` TINYINT NULL,
  `user_id` INT NOT NULL,
  `date_passed` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `date_booked` DATETIME NULL,
  `reservationcol` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_reservation_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `strascook`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`order` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `quantity` VARCHAR(45) NULL,
  `menus_id` INT NOT NULL,
  `reservation_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_order_menus1`
    FOREIGN KEY (`menus_id`)
    REFERENCES `strascook`.`menus` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_reservation1`
    FOREIGN KEY (`reservation_id`)
    REFERENCES `strascook`.`reservation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`email` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_email_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `strascook`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `strascook`.`partenaire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `strascook`.`partenaire` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(255) NULL,
  `title` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `logo_src` VARCHAR(255) NULL,
  `thum_src` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
