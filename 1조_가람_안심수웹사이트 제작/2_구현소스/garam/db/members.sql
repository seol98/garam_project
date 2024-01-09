
CREATE TABLE `members` (
  `num` int NOT NULL,
  `uid` char(30) NOT NULL,
  `pass` char(50) NOT NULL,
  `nickname` char(20) NOT NULL,
  `tel` char(15) NOT NULL,
  `email` char(80) NOT NULL,
  `birth` char(15) DEFAULT NULL,
  `address` char(50) NOT NULL,
  `bottledwater` char(80) DEFAULT NULL,
  `regist_day` char(20) DEFAULT NULL,
  `level` int DEFAULT NULL,
  `login_div` char(20) NOT NULL
   primary key(num)
);