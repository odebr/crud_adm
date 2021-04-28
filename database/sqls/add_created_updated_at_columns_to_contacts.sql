ALTER TABLE `btrulead_btruleads`.`contacts` 
ADD COLUMN `created_at` TIMESTAMP NULL AFTER `datetime`,
ADD COLUMN `updated_at` TIMESTAMP NULL AFTER `created_at`;
