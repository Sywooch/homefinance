-- MySQL Workbench Synchronization
-- Generated: 2016-11-21 17:40
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: JS

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP VIEW v_balance_item;

ALTER TABLE `homefin`.`balance_item` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `balance_type_id`,
ADD INDEX `fk_balance_item_user1_idx` (`user_id` ASC);

ALTER TABLE `homefin`.`balance_sheet` 
ADD COLUMN `user_id` INT(11) NOT NULL AFTER `is_month`,
ADD INDEX `fk_balance_sheet_user1_idx` (`user_id` ASC);

CREATE TABLE IF NOT EXISTS `homefin`.`user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `homefin`.`balance_item` 
ADD CONSTRAINT `fk_balance_item_user1`
  FOREIGN KEY (`user_id`)
  REFERENCES `homefin`.`user` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;

ALTER TABLE `homefin`.`balance_sheet` 
ADD CONSTRAINT `fk_balance_sheet_user1`
  FOREIGN KEY (`user_id`)
  REFERENCES `homefin`.`user` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;


ALTER TABLE `homefin`.`balance_item` 
ADD COLUMN `immutable` TINYINT(1) NULL DEFAULT NULL AFTER `user_id`;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
