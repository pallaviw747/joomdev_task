SQL Queries


CREATE TABLE `joomdev_db`.`users` (`id` INT(11) NOT NULL AUTO_INCREMENT , `first_name` VARCHAR(50) NULL , `last_name` VARCHAR(50) NULL , `email_id` VARCHAR(50) NULL , `phone` VARCHAR(15) NULL , `password` VARCHAR(100) NULL, `role` ENUM('user','admin') NOT NULL DEFAULT 'user', `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=Inactive' , `created_at` DATETIME NOT NULL , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `users` ADD `last_login` DATETIME NULL AFTER `role`, ADD `last_password_change` DATETIME NULL AFTER `last_login`;

CREATE TABLE `joomdev_db`.`user_tasks` (`id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' ,  `start_time` TIMESTAMP NULL , `stop_time` TIMESTAMP NULL , `notes` VARCHAR(50) NULL , `description` VARCHAR(500) NULL , `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive' , `created_at` DATETIME NOT NULL , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;

C+@Z#8
