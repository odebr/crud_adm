ALTER TABLE `btrulead_btruleads`.`users` 
ADD COLUMN `google_token` TEXT NULL AFTER `datetime`,
ADD COLUMN `google_calendar_id` VARCHAR(255) NULL AFTER `google_token`;
