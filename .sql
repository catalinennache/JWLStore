-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Customers` (
  `customer_id` INT NOT NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email_address` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `phone_number` TEXT NULL,
  `address1` TEXT NULL,
  `address2` TEXT NULL,
  PRIMARY KEY (`customer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ref_Order_Status_Codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ref_Order_Status_Codes` (
  `order_status_code` INT NOT NULL,
  `order_status_description` VARCHAR(45) NULL,
  PRIMARY KEY (`order_status_code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Orders` (
  `order_id` INT NOT NULL,
  `customer_id` INT NULL,
  `order_status_code` INT NULL,
  `date_order_placed` DATETIME NULL,
  `order_details` TEXT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `customer_id_idx` (`customer_id` ASC),
  INDEX `order_status_code_idx` (`order_status_code` ASC),
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `mydb`.`Customers` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_status_code`
    FOREIGN KEY (`order_status_code`)
    REFERENCES `mydb`.`Ref_Order_Status_Codes` (`order_status_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ref_Product_Types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ref_Product_Types` (
  `product_type_code` INT NOT NULL,
  `parent_product_type_code` VARCHAR(45) NULL,
  `product_type_description` VARCHAR(45) NULL,
  `product_type_category` VARCHAR(45) NULL,
  PRIMARY KEY (`product_type_code`),
  CONSTRAINT `parent_product_type_code`
    FOREIGN KEY ()
    REFERENCES `mydb`.`Ref_Product_Types` ()
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Products` (
  `product_id` INT NOT NULL,
  `product_type_code` INT NULL,
  `RMA_nr` VARCHAR(45) NULL,
  `product_name` VARCHAR(45) NULL,
  `product_price` FLOAT NULL,
  `product_size` INT NULL,
  `product_description` TEXT NULL,
  PRIMARY KEY (`product_id`),
  INDEX `oriduct_type_code_idx` (`product_type_code` ASC),
  CONSTRAINT `oriduct_type_code`
    FOREIGN KEY (`product_type_code`)
    REFERENCES `mydb`.`Ref_Product_Types` (`product_type_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Order_Items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Order_Items` (
  `order_item_id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NULL,
  `order_id` INT NULL,
  `order_item_status_code` INT NULL,
  `order_item_price` INT NULL,
  `RMA_number` TEXT NULL,
  `RMA_issued_by` TEXT NULL,
  `RMA_issued_date` TEXT NULL,
  `order_item_details` TEXT NULL,
  PRIMARY KEY (`order_item_id`),
  INDEX `order_id_idx` (`order_id` ASC),
  INDEX `product_id_idx` (`product_id` ASC),
  INDEX `order_item_status_code_idx` (`order_item_status_code` ASC),
  CONSTRAINT `order_id`
    FOREIGN KEY (`order_id`)
    REFERENCES `mydb`.`Orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `product_id`
    FOREIGN KEY (`product_id`)
    REFERENCES `mydb`.`Products` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_item_status_code`
    FOREIGN KEY (`order_item_status_code`)
    REFERENCES `mydb`.`Ref_Order_Status_Codes` (`order_status_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ref_Invoice_Status_Codes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ref_Invoice_Status_Codes` (
  `invoice_status_code` INT NOT NULL,
  `invoice_status_description` VARCHAR(45) NULL,
  PRIMARY KEY (`invoice_status_code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Invoices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Invoices` (
  `invoice_number` INT NOT NULL,
  `order_id` INT NULL,
  `invoice_status_code` INT NULL,
  `invoice_date` DATETIME NULL,
  `invoice_details` TEXT NULL,
  PRIMARY KEY (`invoice_number`),
  INDEX `order_id_idx` (`order_id` ASC),
  INDEX `invoice_status_code_idx` (`invoice_status_code` ASC),
  CONSTRAINT `order_id`
    FOREIGN KEY (`order_id`)
    REFERENCES `mydb`.`Orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `invoice_status_code`
    FOREIGN KEY (`invoice_status_code`)
    REFERENCES `mydb`.`Ref_Invoice_Status_Codes` (`invoice_status_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Shipments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Shipments` (
  `shipment_id` INT NOT NULL,
  `order_id` INT NULL,
  `invoice_number` INT NULL,
  `shipment_tracking_number` TEXT NULL,
  `shipment_date` DATETIME NULL,
  `shipment_details` TEXT NULL,
  PRIMARY KEY (`shipment_id`),
  INDEX `order_id_idx` (`order_id` ASC),
  INDEX `invoice_number_idx` (`invoice_number` ASC),
  CONSTRAINT `order_id`
    FOREIGN KEY (`order_id`)
    REFERENCES `mydb`.`Orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `invoice_number`
    FOREIGN KEY (`invoice_number`)
    REFERENCES `mydb`.`Invoices` (`invoice_number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Payments` (
  `payment_id` INT NOT NULL,
  `invoice_number` INT NULL,
  `payment_date` DATETIME NULL,
  `payment_amount` FLOAT NULL,
  PRIMARY KEY (`payment_id`),
  INDEX `invoice_number_idx` (`invoice_number` ASC),
  CONSTRAINT `invoice_number`
    FOREIGN KEY (`invoice_number`)
    REFERENCES `mydb`.`Invoices` (`invoice_number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Ref_Payment_Methods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Ref_Payment_Methods` (
  `payment_method_code` INT NOT NULL,
  `payment_method_description` VARCHAR(45) NULL,
  PRIMARY KEY (`payment_method_code`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Customer_Payment_Methods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Customer_Payment_Methods` (
  `customer_payment_id` INT NOT NULL,
  `customer_id` INT NULL,
  `payment_method_code` INT NULL,
  `credit_card_number` TEXT NULL,
  `payment_method_details` TEXT NULL,
  PRIMARY KEY (`customer_payment_id`),
  INDEX `customer_id_idx` (`customer_id` ASC),
  INDEX `payment_method_code_idx` (`payment_method_code` ASC),
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `mydb`.`Customers` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `payment_method_code`
    FOREIGN KEY (`payment_method_code`)
    REFERENCES `mydb`.`Ref_Payment_Methods` (`payment_method_code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Shipment_Items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Shipment_Items` (
  `shipment_id` INT NOT NULL,
  `order_item_id` INT NOT NULL,
  PRIMARY KEY (`shipment_id`, `order_item_id`),
  INDEX `order_item_id_idx` (`order_item_id` ASC),
  CONSTRAINT `order_item_id`
    FOREIGN KEY (`order_item_id`)
    REFERENCES `mydb`.`Order_Items` (`order_item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `shipment_id`
    FOREIGN KEY (`shipment_id`)
    REFERENCES `mydb`.`Shipments` (`shipment_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
