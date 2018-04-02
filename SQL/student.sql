

CREATE TABLE `colleges_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


INSERT INTO colleges_category VALUES
("1","Tan Yan Kee Building",""),
("2","College of Education",""),
("3","Faculty of Arts and Letters",""),
("4","Institute of Physical Education and Athletics",""),
("5","Institute of Information and Computing Sciences",""),
("6","College of Commerce and Business Administration",""),
("7","Faculty of Engineering",""),
("8","College of Fine Arts and Design",""),
("9","College of Architecture",""),
("10","College of Science",""),
("11","College of Rehabilitation Sciences",""),
("12","College of Nursing",""),
("13","Education High School",""),
("14","Junior High School",""),
("15","Senior High School",""),
("16","Conservatory of Music",""),
("17","Faculty of Pharmacy",""),
("18","AMV College of Accountancy",""),
("19","College of Tourism and Hospitality Management","");




CREATE TABLE `deletedevents` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `venue` text NOT NULL,
  `poster` text NOT NULL,
  `event_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;






CREATE TABLE `deletedsystem_users` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_number` varchar(25) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `email` text NOT NULL,
  `scholarship` text NOT NULL,
  `college` tinyint(4) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `barcode` text NOT NULL,
  `photo` text NOT NULL,
  `position` varchar(50) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `ckey` varchar(220) NOT NULL,
  `ctime` varchar(220) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


INSERT INTO deletedsystem_users VALUES
("19","08976","ertyu","sdfgrthju","saerdth","","csdfghjk@fdgghj.com","","0","0000-00-00","0","","","","grey","5f48bdf23db2fbe2e470a82b5eef467728ced5f3b3ce47975","2","","","1","1","qwerty");




CREATE TABLE `event_attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `event_ID` int(11) NOT NULL,
  `student_ID` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;


INSERT INTO event_attendance VALUES
("26","5","7","11:16:00","23:15:00","1"),
("27","5","11","11:16:00","23:15:00","1"),
("28","5","12","11:16:00","23:15:00","1"),
("29","5","13","11:16:00","23:15:00","1"),
("30","5","14","11:16:00","23:15:00","1"),
("31","5","17","11:16:00","23:15:00","1"),
("32","5","18","11:16:00","23:15:00","1"),
("36","1","2","11:05:37","00:00:00","1"),
("38","1","3","11:11:48","00:00:00","1"),
("41","1","7","13:46:29","00:00:00","1"),
("42","1","11","13:47:28","00:00:00","1"),
("43","1","17","13:50:06","00:00:00","1"),
("44","1","12","13:51:17","00:00:00","1"),
("45","1","18","14:11:12","00:00:00","1"),
("46","1","14","14:11:12","00:00:00","1"),
("47","1","13","14:11:12","00:00:00","1");




CREATE TABLE `events` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `venue` text NOT NULL,
  `poster` text NOT NULL,
  `event_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


INSERT INTO events VALUES
("1","Halloween Party","2016-10-31 08:00:00","2016-11-01 08:00:00","School Compound","","1"),
("4","New Year Party","2016-12-31 08:00:00","2017-01-01 08:00:00","School Compound","jersey.jpg","1"),
("5","Sample Event","2017-11-18 11:16:00","2017-10-17 23:15:00","fsdfsdfsdf","","1"),
("6","New Year Party","2017-12-19 11:17:00","2017-11-17 08:00:00","School Compound","","0");




CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(100) NOT NULL,
  `qtyleft` int(11) NOT NULL,
  `base_price` decimal(11,2) NOT NULL,
  `capital` decimal(11,2) NOT NULL,
  `markup_price` decimal(11,2) NOT NULL,
  `college_ID` int(11) NOT NULL,
  `transaction_code` varchar(25) NOT NULL,
  `stock_code` varchar(25) NOT NULL,
  `last_update` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;


INSERT INTO inventory VALUES
("100","Ballpen","0","12.00","0.00","1.50","7","spucna8","5ny60fr","2016-10-26 03:48:50","0"),
("99","Ballpen","102","12.00","0.00","1.50","7","jy863hx","5ny60fr","2016-10-26 03:46:49","0"),
("98","Ballpen","105","12.00","60.00","1.50","7","jk6o8ug","5ny60fr","2016-10-26 03:39:21","0"),
("97","Ballpen","100","12.00","1200.00","1.50","7","nf6bs43","5ny60fr","2016-10-26 03:37:30","0"),
("101","Ballpen","2","12.00","24.00","1.50","7","h26nuai","5ny60fr","2016-10-26 04:28:13","0"),
("102","Pencil","100","6.00","600.00","1.50","7","9mr8exv","d9a3srg","2016-10-26 04:30:49","0"),
("103","Pencil","100","3.00","0.00","12.00","7","e5bnx6u","d9a3srg","2016-10-26 04:32:31","0"),
("104","Pencil","98","3.00","0.00","12.00","7","wqkcf2o","d9a3srg","2016-10-26 04:36:11","0"),
("105","Books","150","50.00","7500.00","5.00","7","hxqtz91","gtjz3h5","2016-10-26 04:43:43","1"),
("106","Ballpen","152","12.00","1800.00","1.50","7","cahgob0","5ny60fr","2016-10-26 04:44:24","1"),
("107","Pencil","93","3.00","0.00","12.00","7","zw38tku","d9a3srg","2016-10-26 04:46:01","1");




CREATE TABLE `inventory_activity_log` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `transaction_type` tinyint(1) NOT NULL,
  `qty` int(11) NOT NULL,
  `base_price_from` decimal(11,2) NOT NULL,
  `base_price_to` decimal(11,2) NOT NULL,
  `capital` decimal(11,2) NOT NULL,
  `markup_price_from` decimal(11,2) NOT NULL,
  `markup_price_to` decimal(11,2) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_code` varchar(25) NOT NULL,
  `stock_code` varchar(25) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;


INSERT INTO inventory_activity_log VALUES
("94","Add Product","1","100","12.00","0.00","1200.00","1.50","0.00","2016-10-26 03:37:30","1","nf6bs43","5ny60fr"),
("95","Stock Added","2","5","12.00","0.00","60.00","1.50","0.00","2016-10-26 03:39:21","1","jk6o8ug","5ny60fr"),
("96","Item Sold","3","3","12.00","0.00","0.00","1.50","0.00","2016-10-26 03:46:49","1","jy863hx","5ny60fr"),
("97","Item Sold","3","102","12.00","0.00","0.00","1.50","0.00","2016-10-26 03:48:50","1","spucna8","5ny60fr"),
("98","Stock Added","2","2","12.00","0.00","24.00","1.50","0.00","2016-10-26 04:28:13","1","h26nuai","5ny60fr"),
("99","Add Product","1","100","6.00","0.00","600.00","1.50","0.00","2016-10-26 04:30:49","1","9mr8exv","d9a3srg"),
("100","Update Price","4","0","6.00","3.00","0.00","1.50","12.00","2016-10-26 04:32:31","1","e5bnx6u","d9a3srg"),
("101","Item Sold","3","2","3.00","0.00","0.00","12.00","0.00","2016-10-26 04:36:11","1","wqkcf2o","d9a3srg"),
("102","Add Product","1","150","50.00","0.00","7500.00","5.00","0.00","2016-10-26 04:43:43","1","hxqtz91","gtjz3h5"),
("103","Stock Added","2","150","12.00","0.00","1800.00","1.50","0.00","2016-10-26 04:44:24","1","cahgob0","5ny60fr"),
("104","Item Sold","3","5","3.00","0.00","0.00","12.00","0.00","2016-10-26 04:46:01","1","zw38tku","d9a3srg");




CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `sales` decimal(11,2) NOT NULL,
  `transaction_code` varchar(25) NOT NULL,
  `stock_code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;


INSERT INTO sales VALUES
("40","5","2016-10-26 04:46:01","75.00","zw38tku","d9a3srg"),
("39","2","2016-10-26 04:36:11","30.00","wqkcf2o","d9a3srg"),
("38","102","2016-10-26 03:48:50","1377.00","spucna8","5ny60fr"),
("37","3","2016-10-26 03:46:49","40.50","jy863hx","5ny60fr");




CREATE TABLE `scholarship_category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


INSERT INTO scholarship_category VALUES
("1","Saint Martin de Porres - Internal","Saint Martin de Porres Scholarship Internal"),
("2","Saint Martin de Porres - External","Saint Martin de Porres Scholarship External"),
("3","Santo Tomas","Santo Tomas Scholarship"),
("4","San Lorenzo Ruiz","San Lorenzo Ruis Scholarship"),
("5","Santo Domingo de Guzman","Santo Domingo de Guzman Scholarship");




CREATE TABLE `security_question` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO security_question VALUES
("1","What was the name of your elementary / primary school?"),
("2","In what city or town does your nearest sibling live?"),
("3","What time of the day were you born? (hh:mm)"),
("4","What is your pet’s name?"),
("5","In what year was your father born?"),
("6","What is the last name of the teacher who gave you your first failing grade?");




CREATE TABLE `store_items` (
  `item_ID` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(25) NOT NULL,
  `item_name` text NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `particulars` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `college` int(11) NOT NULL,
  PRIMARY KEY (`item_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO store_items VALUES
("1","432EFDF2","Energy Bar","Chocolate Energy Bar","11.50","12","0","1"),
("2","4322EFDF2","Monster Energy Drink","Canned Energy Drink","50.00","12","0","1");




CREATE TABLE `system_users` (
  `user_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_number` varchar(25) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `email` text NOT NULL,
  `scholarship` text NOT NULL,
  `college` tinyint(4) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `barcode` text NOT NULL,
  `photo` text NOT NULL,
  `position` varchar(50) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `ckey` varchar(220) NOT NULL,
  `ctime` varchar(220) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;


INSERT INTO system_users VALUES
("2","1234567145","Nicolas","San Tiago","Juan","","studentnew@testmail.com","Santo Tomas","7","1990-07-18","1","barcode_2.png","10.jpg","","student1","0e04d7cce4ae0514f3c635492b957c121ce6b2edf28a671d9","1","","","1","4","cats"),
("3","3234567890","Juan Felipe","Im student","Dela Cruz","","student2@testmail.com","Saint Martin de Porres Scholarship External","5","1990-07-18","1","","griffin.jpg","","student2","b03b555b989d35cc7679f851719d204748dbb76ed8e14468c","1","","","1","4","dog"),
("12","3213214324","Rogelio","Filipina","Dela Cruz","","desmondnicddao@gmail.com","Saint Martin de Porres - Internal","15","1957-10-14","1","","mater.jpg","","","3c07a2b45cfbaa05a46c1623b83e8c809b4b166cf08b37ff8","1","","","1","4","elepant"),
("13","12345678903","Juana","Filipina","Dela Cruz","","lonewolf0z62977@gmail.com","Saint Martin de Porres - External","14","1957-10-17","0","","","","","c83de320f34a6b0ff802ffb29c280215159c37306f5a14ae2","1","","","1","4","cat"),
("16","766865453243577","Rogelio","fdsgh","rwerqw","","lonewdsolf062977@gmail.com","","0","0000-00-00","1","","","","admin","f9c4e54ebfcc23138fd71c1cb55367cc229691166b8f64d47","2","","","1","4","chicken"),
("17","01162014","Brittany Nicole","Barba","Avillion","","brittanynnicoleavillion@gmail.com","Saint Martin de Porres - External","7","2014-01-16","0","","fghjk.JPG","","","710fa427eef678ab12ba0a11584c47773a0a866638ffe2ccd","1","","","1","4","dog"),
("20","2016000001","Becarios","De","Santo Tomas","","becarios.dst@gmail.com","","0","0000-00-00","1","","","","adminbecarios","bf7c1212d12e7022e91807c3aa4a5e24a7905a343b632a8c5","2","v4zap06","1479217355","1","1","UST"),
("21","2014069814","Katrine Grace","Zantua","Gala","","katrine.grace16@gmail.com","Saint Martin de Porres - Internal","5","1997-10-16","0","","","","","5967ba462413d16372f4c61c3e330f62460babc7f7393b4ca","1","","","1","0","");


