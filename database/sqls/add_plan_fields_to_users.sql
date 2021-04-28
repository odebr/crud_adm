ALTER TABLE `btrulead_leads`.`users`   
	ADD COLUMN `plan_id` INT NULL,
	ADD COLUMN `plan_status` VARCHAR(30) NULL,
	ADD COLUMN `plan_subscribed_at` TIMESTAMP NULL;
ALTER TABLE `btrulead_leads`.`users`   
	ADD COLUMN `plan_payment_gateway` VARCHAR(30) NULL AFTER `plan_status`,
	ADD COLUMN `plan_customer_id` VARCHAR(100) NULL AFTER `plan_payment_gateway`;

ALTER TABLE `btrulead_leads`.`users`   
	ADD COLUMN `plan_expiring` TINYINT NULL AFTER `plan_customer_id`,
	ADD COLUMN `plan_code` VARCHAR(30) NULL AFTER `plan_id`;
