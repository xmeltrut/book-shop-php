DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` numeric(10 , 0) NOT NULL,
  `author` varchar(255),
  `image` varchar(255),
  PRIMARY KEY (`id`)
);

INSERT INTO `book` (`id`,`title`,`price`,`author`,`image`) VALUES (1,'Brave New World',7.99,'Aldous Huxley','brave-new-world.jpg');
INSERT INTO `book` (`id`,`title`,`price`,`author`,`image`) VALUES (2,'Nineteen-Eighty Four',8.99,'George Orwell','nineteen-eighty-four.jpg');
INSERT INTO `book` (`id`,`title`,`price`,`author`,`image`) VALUES (3,'Cannery Row',6.99,'John Steinbeck','cannery-row.jpg');
INSERT INTO `book` (`id`,`title`,`price`,`author`,`image`) VALUES (4,'The Grapes of Wrath',11.99,'John Steinbeck','the-grapes-of-wrath.jpg');
DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) NOT NULL,
  `executed_at` datetime NOT NULL,
  PRIMARY KEY (`version`)
);

INSERT INTO `migration_versions` (`version`,`executed_at`) VALUES ('20200415115649','2020-04-15 11:57:04');