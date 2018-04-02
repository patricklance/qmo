

CREATE TABLE `colleges_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `deletedsystem_users` (
  `user_ID` int(11) NOT NULL,
  `ID_number` varchar(25) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `email` text NOT NULL,
  `alt_email` text NOT NULL,
  `college` text NOT NULL,
  `position` text NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `ckey` varchar(220) NOT NULL,
  `ctime` varchar(220) NOT NULL,
  `approval` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `system_users` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_number` varchar(25) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `email` text NOT NULL,
  `alt_email` text NOT NULL,
  `college` text NOT NULL,
  `position` text NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `ckey` varchar(220) NOT NULL,
  `ctime` varchar(220) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




