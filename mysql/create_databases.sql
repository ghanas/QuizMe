CREATE TABLE `qw_deck_card_rel` (
		`card_id` int(11) NOT NULL,
		`deck_id` int(11) NOT NULL,
		`id` int(11) NOT NULL AUTO_INCREMENT,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_decks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `deck_name` varchar(256) CHARACTER SET latin1 NOT NULL,
  `public` tinyint(4) NOT NULL DEFAULT '0',
  `description` varchar(256) CHARACTER SET latin1 NOT NULL,
  `last_edited` datetime NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_flash_cards` (
  `id` int(11) NOT NULL,
  `front` varchar(256) CHARACTER SET latin1 NOT NULL,
  `back` varchar(256) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_passwords` (
  `user_id` int(11) NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(256) CHARACTER SET latin1 NOT NULL,
  `description` varchar(256) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_subj_user_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_qw_subj_user_rel_1_idx` (`user_id`),
  KEY `fk_qw_subj_user_rel_2_idx` (`subj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `qw_users` (
  `username` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `user_type` int(4) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
