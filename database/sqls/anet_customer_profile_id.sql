ALTER TABLE `btrulead_leads`.`contacts` 
ADD COLUMN `anet_customer_profile_id` VARCHAR(45) NULL AFTER `qb_customer_id`,
ADD COLUMN `anet_customer_payment_profile_id` VARCHAR(45) NULL AFTER `anet_customer_profile_id`;
