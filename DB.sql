-- 创建“ BooksDB ”数据库，字符集为“ utf8 ”，排序规则为 “ utf8_general_ci ”；

CREATE DATABASE BooksDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

-- 使用 BooksDB

USE BooksDB

-- 创建读者类型表

CREATE TABLE `readertype`(
  `rdType` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '读者类型',
  `typeName` VARCHAR(20) DEFAULT NULL COMMENT '类型名称',
  `canLendQty` INT(11) DEFAULT NULL COMMENT '可借书数量',
  `canLendDay` INT(11) DEFAULT NULL COMMENT '可借书天数'
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- readertype 表样例数据

INSERT INTO `readertype` (`rdType`, `typeName`, `canLendQty`, `canLendDay`) VALUES
(1, '教师', 10, 60),
(2, '本科生', 5, 30),
(3, '硕士研究生', 6, 40),
(4, '博士研究生', 8, 50);

-- 创建读者表

CREATE TABLE `reader`(
  `rdID` INT(9) PRIMARY KEY NOT NULL COMMENT '读者编号',
  `rdType` INT(11) DEFAULT NULL COMMENT '读者类型',
  `rdName` VARCHAR(20) DEFAULT NULL COMMENT '读者姓名',
  `rdDept` VARCHAR(40) DEFAULT NULL COMMENT '所在部门',
  `rdQQ` VARCHAR(10) DEFAULT NULL COMMENT '联系QQ',
  `rdBorrowQty` INT(11) DEFAULT '0' COMMENT '已借书数量',
  FOREIGN KEY FK_rdType(rdType) REFERENCES ReaderType(rdType)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- reader 表样例数据

INSERT INTO `reader` (`rdID`, `rdType`, `rdName`, `rdDept`, `rdQQ`, `rdBorrowQty`) VALUES
(2017001, 1, '王桃群', '计算机科学学院', '3635751', 0),
(2017002, 2, '何文杰', '计算机科学学院', '1473516559', 0),
(2017003, 2, '乐治港', '外国语学院', '1711469566', 0),
(2017004, 3, '王世成', '经济学院', '751313504', 0),
(2017005, 4, '孙星', '石油工程学院', '171553775', 0),
(2017006, 4, '程霖', '石油工程学院', '1184047393', 0),
(2017007, 2, '耿天', '计算机科学学院', '1017194476', 1);

UPDATE `reader` SET `rdQQ` = '1184047393' WHERE `reader`.`rdID` = 2017006;

UPDATE `reader` SET `rdID` = '2017008', `rdType` = '3', `rdName` = '程1', `rdDept` = '石油', `rdQQ` = '11840' WHERE `reader`.`rdID` = 2017006

-- 创建图书表

CREATE TABLE `book`(
  `bkID` INT(9) PRIMARY KEY NOT NULL COMMENT '图书编号',
  `bkName` VARCHAR(50) DEFAULT NULL COMMENT '书籍名称',
  `bkAuthor` VARCHAR(50) DEFAULT NULL COMMENT '作者',
  `bkPress` VARCHAR(50) DEFAULT NULL COMMENT '出版社',
  `bkPrice` DECIMAL(5, 2) DEFAULT NULL COMMENT '价格',
  `bkStatus` INT(11) DEFAULT '1' COMMENT '在馆状态'
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- book 表样例数据

INSERT INTO `book` (`bkID`, `bkName`, `bkAuthor`, `bkPress`, `bkPrice`, `bkStatus`) VALUES
(2017001, '数据库原理及应用', '王丽艳', '清华大学出版社', '33.00', 1),
(2017002, '计算机组成与系统结构', '白中英', '科学出版社', '47.00', 1),
(2017003, '微机原理及应用', '李鹏', '电子工业出版社', '56.00', 1),
(2017004, '编译原理', '王生源', '清华大学出版社', '38.00', 1);


-- 创建借书记录表

CREATE TABLE `borrow`(
  `rdID` INT(9) NOT NULL COMMENT '读者编号',
  `bkID` INT(9) NOT NULL COMMENT '图书编号',
  `dateBorrow` DATETIME NOT NULL COMMENT '借书日期',
  `dateLendPlan` DATETIME DEFAULT NULL COMMENT '应还书日期',
  `dateLendAct` DATETIME DEFAULT NULL COMMENT '实际还书日期',
  PRIMARY KEY(rdID, bkID,dateBorrow),
  FOREIGN KEY FK_rdID(rdID) REFERENCES reader(rdID),
  FOREIGN KEY FK_bkID(bkID) REFERENCES book(bkID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- borrow 表插入数据

INSERT INTO `borrow` (`rdID`, `bkID`, `dateBorrow`, `dateLendPlan`, `dateLendAct`) VALUES
(2017007, 2017001, '2017-11-28 00:00:00', '2017-12-28 00:00:00', NULL);

-- 借书存储过程
DELIMITER $$
CREATE
PROCEDURE book_borrow(
  IN `p_rdID` INTEGER,
  IN `p_bkID` INTEGER,
  OUT `p_DateBorrow` DATETIME,
  OUT `p_bkStatus` INTEGER,
  OUT `p_rdBorrowQty` INTEGER,
  OUT `p_canLendQty` INTEGER,
  OUT `p_canLendDay` INTEGER,
  OUT `p_DateLendPlan` DATETIME,
  OUT `p_message` VARCHAR(50)
)
BEGIN
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
END $$
DELIMITER ;

-- 调用借书存储过程
SET
@p0 = '2017007';
SET
@p1 = '2017001';
CALL
`book_borrow`(
    @p0,@p1,@p2,@p3,@p4,@p5,@p6,@p7,@p8
);
SELECT
  @p2 AS `p_DateBorrow`,@p3 AS `p_bkStatus`,@p4 AS `p_rdBorrowQty`,@p5 AS `p_canLendQty`,@p6 AS `p_canLendDay`,@p7 AS `p_DateLendPlan`,@p8 AS `p_message`;


-- 还书存储过程
DELIMITER $$
CREATE
PROCEDURE book_return(
  IN `p_rdID` INTEGER,
  IN `p_bkID` INTEGER,
  IN `p_DateBorrow` DATETIME,
  OUT `p_today` DATETIME,
  OUT `p_exist` INTEGER,
  OUT `p_DateLendPlan` DATETIME,
  OUT `p_dateLendAct` DATETIME,
  OUT `p_message` VARCHAR(50)
)
BEGIN
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
END $$
DELIMITER ;

-- 执行还书存储过程

SET @p0='2017003'; SET @p1='2017003';
SET @p2='2017-12-21 08:57:42';
CALL `book_return`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);
SELECT @p3 AS `p_today`, @p4 AS `p_exist`, @p5 AS `p_DateLendPlan`, @p6 AS `p_dateLendAct`, @p7 AS `p_message`;

SET @p0='2017007'; SET @p1='2017001';
SET @p2='2017-12-20 21:43:15';
CALL `book_return`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);
SELECT @p3 AS `p_today`, @p4 AS `p_exist`, @p5 AS `p_DateLendPlan`, @p6 AS `p_dateLendAct`, @p7 AS `p_message`;