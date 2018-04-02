

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


INSERT INTO deletedsystem_users VALUES
("21","2014069814","Katrine Grace","Zantua","Gala","","katrine.grace16@gmail.com","","5","","0","","5967ba462413d16372f4c61c3e330f62460babc7f7393b4ca","1","","","1");




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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;


INSERT INTO system_users VALUES
("2","1234567145","Nicolas","San Tiago","Juan","","studentnew@testmail.com","","7","","1","student1","7c2c7202437a31e5feb5fffee6676a7fa463d951ec0b63acf","1","","","1"),
("3","3234567890","Juan Felipe","Im student","Dela Cruz","","student2@testmail.com","","5","","1","student2","b03b555b989d35cc7679f851719d204748dbb76ed8e14468c","1","","","1"),
("12","3213214324","Rogelio","Filipina","Dela Cruz","","desmondnicddao@gmail.com","","15","","1","","3c07a2b45cfbaa05a46c1623b83e8c809b4b166cf08b37ff8","1","","","1"),
("13","12345678903","Juana","Filipina","Dela Cruz","","lonewolf0z62977@gmail.com","","14","","0","","c83de320f34a6b0ff802ffb29c280215159c37306f5a14ae2","1","","","1"),
("16","766865453243577","Rogelio","fdsgh","rwerqw","","lonewdsolf062977@gmail.com","","0","","1","admin","f9c4e54ebfcc23138fd71c1cb55367cc229691166b8f64d47","2","","","1"),
("17","01162014","Brittany Nicole","Barba","Avillion","","brittanynnicoleavillion@gmail.com","","7","","0","","710fa427eef678ab12ba0a11584c47773a0a866638ffe2ccd","1","","","1"),
("20","2016000001","Becarios","De","Santo Tomas","","becarios.dst@gmail.com","","0","","1","adminbecarios","bf7c1212d12e7022e91807c3aa4a5e24a7905a343b632a8c5","2","dc1k60q","1516215711","1"),
("22","44144","sadsad","aasdsad","sad","","123@yahoo.com","woe@mai.come","0","sssss","1","student12","357d99de1ccb29b63d4a5d7981ac2b4f5f8ee38f85f1d68be","2","","","1"),
("23","000000","Sample","Admin","Account","","admin@email.com","admin2@email.com","IICS","Student","1","admin1","674798ac4f51f4936331fac264da96c3fd9a50a3cee2de512","2","2zh0kev","1517481062","1"),
("24","111111","test","admin","account","","1223@yahoo.com","ffff@safasf.com","IICS","Student","0","test","80ff94b71ffcbeba64505a73e5c825be4cb254f4a26ca9bcc","2","xpnqecb","1516240247","1"),
("25","21212","test","account","user","","sa@mai.ceeom","sa.d23@email.com","ENGG","Student","0","user","afa5ea607fb8e8920519fdeffc0642dd7596d4175df4d6f41","1","","","1");


