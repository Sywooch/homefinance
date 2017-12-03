-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mefinance_test
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mefinance_test
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mefinance_test` DEFAULT CHARACTER SET utf8 ;
USE `mefinance_test` ;

-- -----------------------------------------------------
-- Table `mefinance_test`.`balance_type_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`balance_type_category` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`balance_type_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`balance_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`balance_type` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`balance_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_code` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `balance_type_category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_type_balance_type_category1_idx` (`balance_type_category_id` ASC),
  CONSTRAINT `fk_balance_type_balance_type_category1`
    FOREIGN KEY (`balance_type_category_id`)
    REFERENCES `mefinance_test`.`balance_type_category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`user` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `auth_id` VARCHAR(64) NULL,
  `username` VARCHAR(256) NOT NULL,
  `password` VARCHAR(256) NULL,
  `email` VARCHAR(256) NULL,
  `auth_key` VARCHAR(256) NULL,
  `auth_token` VARCHAR(256) NULL,
  `create_datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`knowledge_article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`knowledge_article` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`knowledge_article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `full_text` LONGTEXT NULL,
  `image_url` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`ref_balance_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`ref_balance_item` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`ref_balance_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `is_calculated` TINYINT(1) NOT NULL,
  `is_autogenerated` TINYINT(1) NOT NULL,
  `balance_type_id` INT NOT NULL,
  `knowledge_article_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ref_balance_item_balance_type1_idx` (`balance_type_id` ASC),
  INDEX `fk_ref_balance_item_knowledge_article1_idx` (`knowledge_article_id` ASC),
  CONSTRAINT `fk_ref_balance_item_balance_type1`
    FOREIGN KEY (`balance_type_id`)
    REFERENCES `mefinance_test`.`balance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ref_balance_item_knowledge_article1`
    FOREIGN KEY (`knowledge_article_id`)
    REFERENCES `mefinance_test`.`knowledge_article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`balance_item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`balance_item` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`balance_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_num` TINYINT NOT NULL,
  `order_code` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `balance_type_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `ref_balance_item_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_balance_type_idx` (`balance_type_id` ASC),
  INDEX `fk_balance_item_user1_idx` (`user_id` ASC),
  INDEX `fk_balance_item_ref_balance_item1_idx` (`ref_balance_item_id` ASC),
  CONSTRAINT `fk_balance_balance_type`
    FOREIGN KEY (`balance_type_id`)
    REFERENCES `mefinance_test`.`balance_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_item_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mefinance_test`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_item_ref_balance_item1`
    FOREIGN KEY (`ref_balance_item_id`)
    REFERENCES `mefinance_test`.`ref_balance_item` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`balance_sheet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`balance_sheet` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`balance_sheet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `period_start` DATE NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_sheet_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_balance_sheet_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mefinance_test`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`account` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_num` TINYINT NOT NULL,
  `order_code` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `balance_item_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_account_balance_item1_idx` (`balance_item_id` ASC),
  CONSTRAINT `fk_account_balance_item1`
    FOREIGN KEY (`balance_item_id`)
    REFERENCES `mefinance_test`.`balance_item` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`transaction`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`transaction` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`transaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(255) NULL,
  `category` VARCHAR(255) NULL,
  `sub_category` VARCHAR(255) NULL,
  `date` DATE NOT NULL,
  `for_review` TINYINT(1) NOT NULL,
  `account_from_id` INT NULL,
  `account_to_id` INT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_transaction_account1_idx` (`account_from_id` ASC),
  INDEX `fk_transaction_account2_idx` (`account_to_id` ASC),
  INDEX `fk_transaction_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_transaction_account1`
    FOREIGN KEY (`account_from_id`)
    REFERENCES `mefinance_test`.`account` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transaction_account2`
    FOREIGN KEY (`account_to_id`)
    REFERENCES `mefinance_test`.`account` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transaction_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mefinance_test`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`balance_amount`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`balance_amount` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`balance_amount` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `balance_sheet_id` INT NOT NULL,
  `account_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_balance_amount_balance_sheet1_idx` (`balance_sheet_id` ASC),
  INDEX `fk_balance_amount_account1_idx` (`account_id` ASC),
  CONSTRAINT `fk_balance_amount_balance_sheet1`
    FOREIGN KEY (`balance_sheet_id`)
    REFERENCES `mefinance_test`.`balance_sheet` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_amount_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `mefinance_test`.`account` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`system_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`system_settings` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`system_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`user_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`user_settings` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`user_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  `system_settings_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_settings_system_settings1_idx` (`system_settings_id` ASC),
  INDEX `fk_user_settings_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_settings_system_settings1`
    FOREIGN KEY (`system_settings_id`)
    REFERENCES `mefinance_test`.`system_settings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_settings_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mefinance_test`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mefinance_test`.`import_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mefinance_test`.`import_settings` ;

CREATE TABLE IF NOT EXISTS `mefinance_test`.`import_settings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  `payload` VARCHAR(1024) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_import_settings_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_import_settings_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mefinance_test`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



-- -----------------------------------------------------
-- Data for table `mefinance_test`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `mefinance_test`;
INSERT INTO `mefinance_test`.`user` (`id`, `auth_id`, `username`, `password`, `email`, `auth_key`, `auth_token`, `create_datetime`) VALUES (1, NULL, 'admin', '$1$4175$ZEZh1cGO4IxtOEdt/kuXc/', NULL, NULL, NULL, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `mefinance_test`.`system_settings`
-- -----------------------------------------------------
START TRANSACTION;
USE `mefinance_test`;
INSERT INTO `mefinance_test`.`system_settings` (`id`, `name`, `code`, `value`) VALUES (1, 'Balance deviation threshold', 'balance_threshold', '0');

COMMIT;
