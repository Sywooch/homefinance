-- MySQL Workbench Synchronization
-- Generated: 2016-02-05 00:52
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: JS

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `homefin`.`transaction` 
DROP FOREIGN KEY `fk_transaction_balance_item2`,
DROP FOREIGN KEY `fk_transaction_balance_item1`;

ALTER TABLE `homefin`.`transaction` 
DROP COLUMN `to_item_id`,
DROP COLUMN `from_item_id`,
ADD COLUMN `description` VARCHAR(255) NULL DEFAULT NULL AFTER `amount`,
ADD COLUMN `account_from_id` INT(11) NULL DEFAULT NULL AFTER `date`,
ADD COLUMN `account_to_id` INT(11) NULL DEFAULT NULL AFTER `account_from_id`,
ADD INDEX `fk_transaction_account1_idx` (`account_from_id` ASC),
ADD INDEX `fk_transaction_account2_idx` (`account_to_id` ASC),
DROP INDEX `fk_transaction_balance_item2_idx` ,
DROP INDEX `fk_transaction_balance_item1_idx` ;

CREATE TABLE IF NOT EXISTS `homefin`.`account` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_num` TINYINT(4) NOT NULL,
  `order_code` VARCHAR(45) NULL DEFAULT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `balance_item_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_account_balance_item1_idx` (`balance_item_id` ASC),
  CONSTRAINT `fk_account_balance_item1`
    FOREIGN KEY (`balance_item_id`)
    REFERENCES `homefin`.`balance_item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `homefin`.`transaction` 
ADD CONSTRAINT `fk_transaction_account1`
  FOREIGN KEY (`account_from_id`)
  REFERENCES `homefin`.`account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_transaction_account2`
  FOREIGN KEY (`account_to_id`)
  REFERENCES `homefin`.`account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `homefin`.`balance_amount` 
DROP FOREIGN KEY `fk_balance_amount_balance_item1`;

ALTER TABLE `homefin`.`balance_amount` 
DROP COLUMN `balance_item_id`,
ADD COLUMN `account_id` INT(11) NOT NULL AFTER `balance_sheet_id`,
ADD INDEX `fk_balance_amount_account1_idx` (`account_id` ASC),
DROP INDEX `fk_balance_amount_balance_item1_idx` ;

ALTER TABLE `homefin`.`balance_amount` 
ADD CONSTRAINT `fk_balance_amount_account1`
  FOREIGN KEY (`account_id`)
  REFERENCES `homefin`.`account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
