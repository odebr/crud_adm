CREATE TABLE `btrulead_leads`.`merchant_subscription_plans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(45) NULL,
  `desc` TEXT NULL,
  `price` FLOAT NULL,
  `interval` INT NULL,
  `unit` VARCHAR(50) NULL,
  `trial_period` INT NULL,
  `max_period` VARCHAR(45) NULL,
  `status` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `btrulead_leads`.`merchant_subscriptions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `plan_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `userid` VARCHAR(45) NOT NULL,
  `subscribed_at` TIMESTAMP NULL,
  `ends_at` TIMESTAMP NULL,
  `period` INT NULL,
  `status` VARCHAR(45) NULL,
  `payment_gateway` VARCHAR(45) NULL,
  `customer_id` VARCHAR(45) NULL,
  `subscription_id` VARCHAR(45) NULL,
  `subscription_pay_id` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));
