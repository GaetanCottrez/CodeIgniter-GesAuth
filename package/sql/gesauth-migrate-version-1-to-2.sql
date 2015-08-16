ALTER TABLE `gesauth_users`
ADD `login` varchar(50) COLLATE 'utf8_general_ci' NOT NULL AFTER `id`;

UPDATE `gesauth_users` SET `login` = `id`;

ALTER TABLE `gesauth_users`
DROP `id`;

ALTER TABLE `gesauth_users`
ADD `id` mediumint(5) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

UPDATE `gesauth_user_to_role` LEFT JOIN `gesauth_users` ON `gesauth_users`.login = `gesauth_user_to_role`.user_id SET `gesauth_user_to_role`.user_id = `gesauth_users`.id
