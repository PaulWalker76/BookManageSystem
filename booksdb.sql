-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2018-09-08 03:03:24
-- 服务器版本： 5.7.23
-- PHP 版本： 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `booksdb`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `book_borrow` (IN `p_rdID` INTEGER, IN `p_bkID` INTEGER, OUT `p_DateBorrow` DATETIME, OUT `p_bkStatus` INTEGER, OUT `p_rdBorrowQty` INTEGER, OUT `p_canLendQty` INTEGER, OUT `p_canLendDay` INTEGER, OUT `p_DateLendPlan` DATETIME, OUT `p_message` VARCHAR(50))  BEGIN
  SELECT NOW() INTO p_DateBorrow ;
  SELECT bkStatus INTO p_bkStatus FROM book WHERE bkID = p_bkID ;
  SELECT rdBorrowQty INTO p_rdBorrowQty FROM Reader WHERE rdID = p_rdID ;
  SELECT canLendQty, canLendDay INTO p_canLendQty, p_canLendDay FROM Reader, ReaderType WHERE Reader.rdID = p_rdID AND Reader.rdType = ReaderType.rdType ;
  SELECT date_add(p_DateBorrow, interval p_canLendDay day) INTO p_DateLendPlan;
  IF p_bkStatus = 1 THEN
    IF p_canLendQty>p_rdBorrowQty THEN
      START TRANSACTION;
      INSERT INTO Borrow VALUES( p_rdID,p_bkID,p_DateBorrow,p_DateLendPlan,NULL);
      UPDATE Book SET bkStatus = 0 WHERE bkID = p_bkID;
      UPDATE Reader SET rdBorrowQty = rdBorrowQty + 1
      WHERE rdID = p_rdID;
      COMMIT;
      SET p_message = '借书成功';
    ELSE
      SET p_message = '当前读者可借书数量已满';
    END IF;
  ELSE
    SET p_message = '该书籍不在馆';
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `book_return` (IN `p_rdID` INTEGER, IN `p_bkID` INTEGER, IN `p_DateBorrow` DATETIME, OUT `p_today` DATETIME, OUT `p_exist` INTEGER, OUT `p_DateLendPlan` DATETIME, OUT `p_dateLendAct` DATETIME, OUT `p_message` VARCHAR(50))  BEGIN
  SELECT NOW() INTO p_today ;
  SELECT COUNT(*),dateLendAct INTO p_exist,p_dateLendAct FROM borrow WHERE rdID=p_rdID AND bkID=p_bkID AND dateBorrow=p_DateBorrow;
  SELECT DateLendPlan INTO p_DateLendPlan FROM borrow WHERE rdID=p_rdID AND bkID=p_bkID AND dateBorrow=p_DateBorrow;
  IF (p_exist > 0) THEN
    IF (p_dateLendAct IS NULL) THEN
      IF (p_today<p_DateLendPlan) THEN
        START TRANSACTION;
        UPDATE Book SET bkStatus = 1 WHERE bkID = p_bkID;
        UPDATE Reader SET rdBorrowQty = rdBorrowQty - 1 WHERE rdID = p_rdID;
        UPDATE borrow SET dateLendAct = NOW()
        WHERE rdID = p_rdID AND bkID = p_bkID AND DateBorrow = p_DateBorrow;
        COMMIT;
        SET p_message = '还书成功';
      ELSE
        SET p_message = '已超期，请缴清违约费用再还书';
      END IF;
    ELSE
      SET p_message = '该书籍已归还';
    END IF;
  ELSE
    SET p_message = '不存在该借书记录';
  END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE `book` (
  `bkID` int(9) NOT NULL COMMENT '图书编号',
  `bkName` varchar(50) DEFAULT NULL COMMENT '书籍名称',
  `bkAuthor` varchar(50) DEFAULT NULL COMMENT '作者',
  `bkPress` varchar(50) DEFAULT NULL COMMENT '出版社',
  `bkPrice` decimal(5,2) DEFAULT NULL COMMENT '价格',
  `bkStatus` int(11) DEFAULT '1' COMMENT '在馆状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`bkID`, `bkName`, `bkAuthor`, `bkPress`, `bkPrice`, `bkStatus`) VALUES
(2017001, '数据库原理及应用', '王丽艳', '清华大学出版社', '33.00', 0),
(2017002, '计算机组成与系统结构', '白中英', '科学出版社', '47.00', 1),
(2017003, '微机原理及应用', '李鹏', '电子工业出版社', '56.00', 1),
(2017004, '编译原理', '王生源', '清华大学出版社', '38.00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

CREATE TABLE `borrow` (
  `rdID` int(9) NOT NULL COMMENT '读者编号',
  `bkID` int(9) NOT NULL COMMENT '图书编号',
  `dateBorrow` datetime NOT NULL COMMENT '借书日期',
  `dateLendPlan` datetime DEFAULT NULL COMMENT '应还书日期',
  `dateLendAct` datetime DEFAULT NULL COMMENT '实际还书日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `borrow`
--

INSERT INTO `borrow` (`rdID`, `bkID`, `dateBorrow`, `dateLendPlan`, `dateLendAct`) VALUES
(2017007, 2017001, '2017-11-28 00:00:00', '2017-12-28 00:00:00', NULL),
(2017007, 2017001, '2018-09-08 11:02:15', '2018-10-08 11:02:15', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `reader`
--

CREATE TABLE `reader` (
  `rdID` int(9) NOT NULL COMMENT '读者编号',
  `rdType` int(11) DEFAULT NULL COMMENT '读者类型',
  `rdName` varchar(20) DEFAULT NULL COMMENT '读者姓名',
  `rdDept` varchar(40) DEFAULT NULL COMMENT '所在部门',
  `rdQQ` varchar(10) DEFAULT NULL COMMENT '联系QQ',
  `rdBorrowQty` int(11) DEFAULT '0' COMMENT '已借书数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `reader`
--

INSERT INTO `reader` (`rdID`, `rdType`, `rdName`, `rdDept`, `rdQQ`, `rdBorrowQty`) VALUES
(2017001, 1, '王桃群', '计算机科学学院', '3635751', 0),
(2017002, 2, '何文杰', '计算机科学学院', '1473516559', 0),
(2017003, 2, '乐治港', '外国语学院', '1711469566', 0),
(2017004, 3, '王世成', '经济学院', '751313504', 0),
(2017005, 4, '孙星', '石油工程学院', '171553775', 0),
(2017006, 4, '程霖', '石油工程学院', '1184047393', 0),
(2017007, 2, '耿天', '计算机科学学院', '1017194476', 2);

-- --------------------------------------------------------

--
-- 表的结构 `readertype`
--

CREATE TABLE `readertype` (
  `rdType` int(11) NOT NULL COMMENT '读者类型',
  `typeName` varchar(20) DEFAULT NULL COMMENT '类型名称',
  `canLendQty` int(11) DEFAULT NULL COMMENT '可借书数量',
  `canLendDay` int(11) DEFAULT NULL COMMENT '可借书天数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `readertype`
--

INSERT INTO `readertype` (`rdType`, `typeName`, `canLendQty`, `canLendDay`) VALUES
(1, '教师', 10, 60),
(2, '本科生', 5, 30),
(3, '硕士研究生', 6, 40),
(4, '博士研究生', 8, 50);

--
-- 转储表的索引
--

--
-- 表的索引 `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bkID`);

--
-- 表的索引 `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`rdID`,`bkID`,`dateBorrow`),
  ADD KEY `FK_bkID` (`bkID`);

--
-- 表的索引 `reader`
--
ALTER TABLE `reader`
  ADD PRIMARY KEY (`rdID`),
  ADD KEY `FK_rdType` (`rdType`);

--
-- 表的索引 `readertype`
--
ALTER TABLE `readertype`
  ADD PRIMARY KEY (`rdType`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `readertype`
--
ALTER TABLE `readertype`
  MODIFY `rdType` int(11) NOT NULL AUTO_INCREMENT COMMENT '读者类型', AUTO_INCREMENT=5;

--
-- 限制导出的表
--

--
-- 限制表 `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`rdID`) REFERENCES `reader` (`rdID`),
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`bkID`) REFERENCES `book` (`bkID`);

--
-- 限制表 `reader`
--
ALTER TABLE `reader`
  ADD CONSTRAINT `reader_ibfk_1` FOREIGN KEY (`rdType`) REFERENCES `readertype` (`rdType`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
