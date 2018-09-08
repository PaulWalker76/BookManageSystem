# 图书管理系统

![项目演示](https://github.com/hovenjay/BookManageSystem/blob/master/images/demo.gif)

## 1. 项目简介

在一周内设计一个图书管理系统，使用任意数据库和编程语言，主要任务包括：

- 了解 C/S 或 B/S 应用程序的多层体系结构及三层架构方案设计思想，了解迭代式开发，熟悉面向对象设计方法及其分析与设计过程，了解 UML 文档及其开发过程中的作用。
- 掌握使用该语言开发一个数据库应用系统的基本方法和步骤，熟悉一些基础功能的实现方法，如：数据维护（插删改等操作），数据查询、浏览，统计与报表，用户登录等。
- 掌握在数据库系统下建立图书管理系统所使用的数据表、视图、约束、存储过程和触发器等；

## 2. 开发环境

- 操作系统：Windows 10
- 浏览器：Google Chrome
- 服务器：Apache Version: 2.4.23
- 编程语言：PHP、HTML/CSS、bootstrap、jQuery、Ajax
- 数据库：MySQL Version: 5.7.14
- 开发工具：IDEA（需要在插件市场里增加 PHP 支持）

## 3. 系统设计

### 3.1 数据库设计

**读者类型表（readertype）**

| **字段名** | **字段类型** | **约束**    | **备注**   |
| ---------- | ------------ | ----------- | ---------- |
| rdType     | INT(11)      | PRIMARY KEY | 读者类型   |
| typeName   | VARCHAR(20)  | NULL        | 类型名称   |
| canLendQty | INT(11)      | NULL        | 可借书数量 |
| canLendDay | INT(11)      | NULL        | 可借书天数 |

**读者表（reader）**

| **字段名**  | **字段类型** | **约束**                      | **备注**   |
| ----------- | ------------ | ----------------------------- | ---------- |
| rdID        | INT(9)       | PRIMARY KEY                   | 读者ID     |
| rdType      | INT(11)      | REFERENCES ReaderType(rdType) | 读者类型   |
| rdName      | VARCHAR(20)  | NULL                          | 读者姓名   |
| rdDept      | VARCHAR(40)  | NULL                          | 所在部门   |
| rdQQ        | VARCHAR(10)  | NULL                          | 联系QQ     |
| rdBorrowQty | INT(11)      | DEFAULT '0'                   | 已借书数量 |

**书籍表（book）**

| **字段名** | **字段类型**   | **约束**    | **备注** |
| ---------- | -------------- | ----------- | -------- |
| bkID       | INT(9)         | PRIMARY KEY | 图书编号 |
| bkName     | VARCHAR(50)    | NULL        | 书籍名称 |
| bkAuthor   | VARCHAR(50)    | NULL        | 作者     |
| bkPress    | VARCHAR(50)    | NULL        | 出版社   |
| bkPrice    | DECIMAL(5， 2) | NULL        | 价格     |
| bkStatus   | INT(11)        | NULL        | 在馆状态 |

**借阅记录表（borrow）**

| **字段名**   | **字段类型** | **约束**                             | **备注**     |
| ------------ | ------------ | ------------------------------------ | ------------ |
| rdID         | INT(9)       | PRIMARY KEY  REFERENCES reader(rdID) | 读者编号     |
| bkID         | INT(9)       | PRIMARY KEY REFERENCES book(bkID)    | 图书编号     |
| dateBorrow   | DATETIME     | NULL                                 | 借书日期     |
| dateLendPlan | DATETIME     | NULL                                 | 应还书日期   |
| dateLendAct  | DATETIME     | NULL                                 | 实际还书日期 |

### 3.2 需求概要

图书管理系统的基本功能需求包括：

- 读者管理：
  - 查询读者：查询时将读者的类型的数字替换为 ReaderType表内的对应的类型。
  - 新增读者：新增读者自动编号。
  - 删除读者：删除之前要判断读者是否有书未归还，在有书籍未归还的情况下无法删除读者。
  - 修改读者信息：除了读者 ID 以外，其它信息可自由修改。
- 图书管理：
  - 查询书籍：书籍可以以各种属性进行模糊查询。
  - 添加图书：书号自动生成，其他信息以表单形式提交。
  - 删除图书：书号不能修改，其他信息可以修改。
  - 修改图书：为了防止相关联的借阅记录出错，当书籍未归还的时候不能还书。
- 借阅管理：
  - 图书借阅：
    - 输入书籍 ID、读者 ID、系统自动获取当前时间生成借书记录。
    - 在生成借书记录时要判断该读者借书数量是否达到上限，如果达到则借阅失败。
    - 在生成借书记录时，要判断该书籍是否在馆，如果不在馆，则借阅失败。
    - 在生成借书记录时，需要获取该读者可以借书的天数，并计算出最晚的还书日期。
  - 图书归还：
    - 在对应的借阅记录后选择还书，即可归还图书。
    - 还书时，要对应的修改书籍在馆状态、读者可借书数量。
  - 查询借阅记录：
    - 可以通过读者 ID / 书籍 ID 查询借阅记录。
    - 借书记录中，如果书籍是已归还的，则还书功能不可用。

![](https://github.com/hovenjay/BookManageSystem/blob/master/images/uml1.png)

![](https://github.com/hovenjay/BookManageSystem/blob/master/images/uml2.png)