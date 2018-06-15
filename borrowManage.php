<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>借阅管理 - 图书管理系统</title>
    <link rel="icon" href="http://localhost/BMS/images/1.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="http://localhost/BMS/images/1.ico" type="image/x-icon"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- 导航模块 -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <!-- 导航栏 LOGO-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">图书管理系统</a>
        </div>
        <!-- 导航栏 LOGO-->
        <!-- 导航栏 菜单 -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="./bookManage.php">书籍管理</a>
                </li>
                <li>
                    <a href="./readerManage.php">读者管理</a>
                </li>
                <li>
                    <a href="./borrowManage.php">借阅管理</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" data-toggle="modal" data-target="#bBook">借书</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#About">关于</a>
                </li>
            </ul>
        </div>
        <!-- 导航栏 菜单 -->
    </div>
</nav>
<!-- 导航模块 -->
<!-- borrow 表 -->
<div class="container">
    <form id="search" action="./borrowManage.php" method="get">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control" id="items" name="items">
                    <option value="reader.rdID">读者编号</option>
                    <option value="book.bkID">书籍编号</option>
                </select>
            </div>
            <div class="col-md-8 form-group">
                <input class="form-control" type="text" name="wd" placeholder="请输入搜索关键词......" required>
            </div>
            <div class="col-md-2 form-group">
                <button type="submit" class="btn btn-primary btn-block">搜索</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class='table table-responsive table-bordered table-hover'>
            <tr>
                <th>读者编号</th>
                <th>读者姓名</th>
                <th>图书编号</th>
                <th>图书名称</th>
                <th>借书日期</th>
                <th>应还书日期</th>
                <th>实际还书日期</th>
                <th class="text-center">操作</th>
            </tr>
            <?php
            require_once 'dbConn.php';
            if (isset($_GET['items'])) {
                $items = $_GET['items'];
                $wd = $_GET['wd'];
                $sql = "SELECT
                          borrow.rdID,
                          reader.rdName,
                          borrow.bkID,
                          book.bkName,
                          borrow.dateBorrow,
                          borrow.dateLendPlan,
                          borrow.dateLendAct
                        FROM
                          borrow
                        JOIN
                          reader
                        ON
                          borrow.rdID = reader.rdID
                        JOIN
                          book
                        ON
                          borrow.bkID = book.bkID
                        WHERE $items = $wd
                        ORDER BY `borrow`.`dateBorrow`";
            } else {
                $sql = "SELECT
                          borrow.rdID,
                          reader.rdName,
                          borrow.bkID,
                          book.bkName,
                          borrow.dateBorrow,
                          borrow.dateLendPlan,
                          borrow.dateLendAct
                        FROM
                          borrow
                        JOIN
                          reader
                        ON
                          borrow.rdID = reader.rdID
                        JOIN
                          book
                        ON
                          borrow.bkID = book.bkID
                        ORDER BY `borrow`.`dateBorrow`;";
            }
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row[0] . "</td>";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "<td>" . $row[3] . "</td>";
                echo "<td>" . $row[4] . "</td>";
                echo "<td>" . $row[5] . "</td>";
                if (is_null($row[6])) {
                    $dateLendAct = '未归还';
                    echo "<td>" . $dateLendAct . "</td>";
                    echo "<td><button type='submit' class='btn btn-info btn-xs btn-block return_bk' data-toggle='modal' data-target='#ReturnBook' id1='$row[0]' id2=' $row[2]' id3=' $row[4]'>还书</button></td>";
                } else {
                    echo "<td>" . $row[6] . "</td>";
                    echo "<td><button type='submit' class='btn btn-info btn-xs btn-block return_bk' disabled='disabled' id1='$row[0]' id2=' $row[2]' id3=' $row[4]'>还书</button></td>";
                }
                echo "</tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
    </div>
</div>
<!-- borrow 表 -->
<!-- 版权声明 -->
<footer class="footer navbar-fixed-bottom">
    <p class="text-center">图书借阅系统 © 长江大学 计算机科学学院 计算机科学与技术 11503 班 何文杰</p>
</footer>
<!-- 版权声明 -->
<!-- #About -->
<div class="modal fade" id="About" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">关于</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-center">图书借阅系统</h4>
                <p>　　本系统由长江大学计算机科学学院计科 11503 班何文杰开发，用于 SQL Server 课程设计，目前已实现如下功能：</p>
                <p>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>　图书借阅；</p>
                <p>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>　图书归还；</p>
                <p>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>　读者管理；</p>
                <p>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>　书籍管理；</p>
                <p>
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>　借阅记录管理；</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- #About -->
<!-- #BorrowBook -->
<div class="modal fade" id="bBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">借书</h4>
            </div>
            <div class="modal-body">
                <form id="bkAddForm">
                    <div class="form-group">
                        <label for="borrow_rdID">读者编号：</label>
                        <input class="form-control" type="text" id="borrow_rdID" name="borrow_rdID" value="2017003"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="borrow_bkID">书籍编号：</label>
                        <input class="form-control" type="text" id="borrow_bkID" name="borrow_bkID" value="2017003"
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" id="bBook_submit">提交</button>
            </div>
        </div>
    </div>
</div>
<!-- #BorrowBook -->
<!-- #ReturnBook -->
<div class="modal fade" id="ReturnBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">删除读者</h4>
            </div>
            <div class="modal-body">
                <p>你确定归还该书籍吗？</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="bkReturnSubmit">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- #ReturnBook -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    // 响应借书表单提交按钮
    $("#bBook_submit").click(function (e) {
        var rdID = $("#borrow_rdID").val();
        var bkID = $("#borrow_bkID").val();
        $.post("borrowBook.php", {
            'rdID': parseInt(rdID),
            'bkID': parseInt(bkID)
        }, function (data) {
            $("#bBook").modal("hide");
            alert(data);
            window.location.reload();
        });
    })
    // 响应还书按钮对应行记录的值
    var rdID = 0;
    var bkID = 0;
    var dateBorrow = '';
    $(".return_bk").click(function (e) {
        rdID = $(e.target).attr("id1");
        bkID = $(e.target).attr("id2");
        dateBorrow = $(e.target).attr("id3");
    })
    // 响应还书确认按钮
    $("#bkReturnSubmit").click(function (e) {
        $.post("returnBook.php", {
            'rdID': parseInt(rdID),
            'bkID': parseInt(bkID),
            'dateBorrow': dateBorrow
        }, function (data) {
            alert(data);
            window.location.reload();
        });
    })
</script>
</body>

</html>