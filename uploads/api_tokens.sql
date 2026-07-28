-- Run this once on any environment that needs the "Receive Orders" desktop
-- app API (application/controllers/Api.php). Already applied to the local
-- fooyesco_updated database.
CREATE TABLE IF NOT EXISTS `api_tokens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `token_hash` VARCHAR(64) NOT NULL,
  `device_name` VARCHAR(255) DEFAULT NULL,
  `created_at` INT(11) NOT NULL,
  `last_used_at` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_hash` (`token_hash`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
