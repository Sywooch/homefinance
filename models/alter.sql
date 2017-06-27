-- MySQL Workbench Synchronization
-- Generated: 2017-06-19 18:44
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: JS

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `homefin`.`balance_item` 
DROP COLUMN `immutable`,
ADD COLUMN `ref_balance_item_id` INT(11) NULL DEFAULT NULL AFTER `user_id`,
ADD INDEX `fk_balance_item_ref_balance_item1_idx` (`ref_balance_item_id` ASC);

ALTER TABLE `homefin`.`balance_type` 
DROP COLUMN `is_active`,
DROP COLUMN `is_det`,
ADD COLUMN `balance_type_category_id` INT(11) NOT NULL AFTER `name`,
ADD INDEX `fk_balance_type_balance_type_category1_idx` (`balance_type_category_id` ASC);

ALTER TABLE `homefin`.`balance_sheet` 
DROP COLUMN `is_month`;

ALTER TABLE `homefin`.`transaction` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `account_to_id`,
ADD INDEX `fk_transaction_user1_idx` (`user_id` ASC);

CREATE TABLE IF NOT EXISTS `homefin`.`ref_balance_item` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `is_calculated` TINYINT(1) NOT NULL,
  `balance_type_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ref_balance_item_balance_type1_idx` (`balance_type_id` ASC),
  CONSTRAINT `fk_ref_balance_item_balance_type1`
    FOREIGN KEY (`balance_type_id`)
    REFERENCES `homefin`.`balance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `homefin`.`balance_type_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `homefin`.`system_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `homefin`.`user_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  `system_settings_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_settings_system_settings1_idx` (`system_settings_id` ASC),
  INDEX `fk_user_settings_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_settings_system_settings1`
    FOREIGN KEY (`system_settings_id`)
    REFERENCES `homefin`.`system_settings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_settings_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `homefin`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `homefin`.`import_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `payload` VARCHAR(1024) NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_import_settings_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_import_settings_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `homefin`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `homefin`.`balance_item` 
ADD CONSTRAINT `fk_balance_item_ref_balance_item1`
  FOREIGN KEY (`ref_balance_item_id`)
  REFERENCES `homefin`.`ref_balance_item` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `homefin`.`balance_type` 
ADD CONSTRAINT `fk_balance_type_balance_type_category1`
  FOREIGN KEY (`balance_type_category_id`)
  REFERENCES `homefin`.`balance_type_category` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `homefin`.`transaction` 
ADD CONSTRAINT `fk_transaction_user1`
  FOREIGN KEY (`user_id`)
  REFERENCES `homefin`.`user` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
