ALTER TABLE `btrulead_leads`.`users`
	CHANGE `google_token` `google_token` TEXT CHARSET utf8 COLLATE utf8_unicode_ci NULL,
	CHANGE `google_calendar_id` `google_calendar_id` VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci NULL,
	CHANGE `company_code` `company_code` VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `btrulead_leads`.`users`
	CHANGE `user_number` `user_number` VARCHAR(255) CHARSET utf8 COLLATE utf8_unicode_ci NULL;
