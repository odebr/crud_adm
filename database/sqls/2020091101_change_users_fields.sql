ALTER TABLE `btrulead_leads`.`users`
	CHANGE `qb_client_id` `qb_client_id` VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci NULL,
	CHANGE `qb_client_secret` `qb_client_secret` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL;
