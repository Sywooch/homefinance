-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema homefin
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema homefin
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `homefin` DEFAULT CHARACTER SET utf8 ;
USE `homefin` ;

-- -----------------------------------------------------
-- Table `homefin`.`balance_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`balance_type` ;

CREATE TABLE IF NOT EXISTS `homefin`.`balance_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `is_det` TINYINT(1) NOT NULL,
  `is_active` TINYINT(1) NULL,
  `order_code` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homefin`.`balance_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`balance_item` ;

CREATE TABLE IF NOT EXISTS `homefin`.`balance_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_num` TINYINT NOT NULL,
  `order_code` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `balance_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_balance_type_idx` (`balance_type_id` ASC),
  CONSTRAINT `fk_balance_balance_type`
    FOREIGN KEY (`balance_type_id`)
    REFERENCES `homefin`.`balance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homefin`.`balance_sheet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`balance_sheet` ;

CREATE TABLE IF NOT EXISTS `homefin`.`balance_sheet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `period_start` DATE NOT NULL,
  `is_month` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homefin`.`account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`account` ;

CREATE TABLE IF NOT EXISTS `homefin`.`account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_num` TINYINT NOT NULL,
  `order_code` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `balance_item_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_account_balance_item1_idx` (`balance_item_id` ASC),
  CONSTRAINT `fk_account_balance_item1`
    FOREIGN KEY (`balance_item_id`)
    REFERENCES `homefin`.`balance_item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homefin`.`transaction`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`transaction` ;

CREATE TABLE IF NOT EXISTS `homefin`.`transaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(255) NULL,
  `date` DATE NOT NULL,
  `account_from_id` INT NULL,
  `account_to_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_transaction_account1_idx` (`account_from_id` ASC),
  INDEX `fk_transaction_account2_idx` (`account_to_id` ASC),
  CONSTRAINT `fk_transaction_account1`
    FOREIGN KEY (`account_from_id`)
    REFERENCES `homefin`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transaction_account2`
    FOREIGN KEY (`account_to_id`)
    REFERENCES `homefin`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homefin`.`balance_amount`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `homefin`.`balance_amount` ;

CREATE TABLE IF NOT EXISTS `homefin`.`balance_amount` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `balance_sheet_id` INT NOT NULL,
  `account_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_amount_balance_sheet1_idx` (`balance_sheet_id` ASC),
  INDEX `fk_balance_amount_account1_idx` (`account_id` ASC),
  CONSTRAINT `fk_balance_amount_balance_sheet1`
    FOREIGN KEY (`balance_sheet_id`)
    REFERENCES `homefin`.`balance_sheet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_amount_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `homefin`.`account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

GRANT ALL ON `homefin`.* TO 'homefin';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `homefin`.`balance_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `homefin`;
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (1, 1, 1, '1.1.', 'Высоколиквидные активы');
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (2, 1, 1, '1.2.', 'Среднеликвидные активы');
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (3, 1, 1, '1.3.', 'Низколиквидные активы');
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (4, 1, 0, '2.1.', 'Капитал');
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (5, 1, 0, '2.2.', 'Резервы');
INSERT INTO `homefin`.`balance_type` (`id`, `is_det`, `is_active`, `order_code`, `name`) VALUES (6, 1, 0, '2.3.', 'Обязательства');

COMMIT;

