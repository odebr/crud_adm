CREATE TABLE `activities_mine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255)  NOT NULL,
  `contact_id` varchar(255)  DEFAULT NULL,
  `title` varchar(255)  NOT NULL,
  `description` text  DEFAULT NULL,
  `location` varchar(255)  DEFAULT NULL,
  `timezone` varchar(255)  DEFAULT NULL,
  `date` varchar(255)  NOT NULL,
  `time` varchar(255)  DEFAULT NULL,
  `end_date` varchar(255)  DEFAULT NULL,
  `reminder` varchar(255)  DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
