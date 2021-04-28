ALTER TABLE `btrulead_leads`.`users` 
ADD COLUMN `qb_token_created_at` TIMESTAMP NULL AFTER `qb_client_secret`,
ADD COLUMN `qb_refresh_token_used` TINYINT NULL AFTER `qb_token_created_at`;
ALTER TABLE `btrulead_leads`.`users` 
CHANGE COLUMN `qb_token_created_at` `qb_access_token_expire_at` TIMESTAMP NULL DEFAULT NULL ,
CHANGE COLUMN `qb_refresh_token_used` `qb_refresh_token_expire_at` TIMESTAMP NULL DEFAULT NULL ;
