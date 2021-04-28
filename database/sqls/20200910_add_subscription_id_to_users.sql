ALTER TABLE `btrulead_leads`.`users`
	ADD COLUMN `plan_subscription_id` VARCHAR(100) NULL AFTER `plan_expiring`;
