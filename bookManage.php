<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>书籍管理 - 图书管理系统</title>
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
                <li><a href="#" data-toggle="modal" data-target="#newBook">添加书籍</a></li>
                <li><a href="#" data-toggle="modal" data-target="#About">关于</a></li>
            </ul>
        </div>
        <!-- 导航栏 菜单 -->
    </div>
</nav>
<!-- 导航模块 -->
<!-- book 表 -->
<div class="container">
    <div class="table-responsive">
        <table class='table table-responsive table-bordered table-hover'>
            <tr>
                <th>图书编号</th>
                <th>书籍名称</th>
                <th>作者</th>
                <th>出版社</th>
                <th>价格</th>
                <th>在馆状态</th>
                <th colspan="2" class="text-center">操作</th>
            </tr>
            <?php
            require_once 'dbConn.php';
            if (isset($_GET['items'])) {
                $sql = "SELECT * FROM `book` WHERE `$_GET[items]` LIKE '%$_GET[wd]%'";
            } else {
                $sql = "SELECT * FROM `book`";
            }
            $result = mysqli_query($conn, $sql);
            $bkStatus = '';
            while ($row = mysqli_fetch_array($result)) {
                if ($row['bkStatus'] >= 1) {
                    $bkStatus = '在馆';
                } else {
                    $bkStatus = '不在馆';
                }
                echo "<tr>";
                echo "<td>" . $row['bkID'] . "</td>";
                echo "<td>" . $row['bkName'] . "</td>";
                echo "<td>" . $row['bkAuthor'] . "</td>";
                echo "<td>" . $row['bkPress'] . "</td>";
                echo "<td>" . $row['bkPrice'] . "</td>";
                echo "<td>" . $bkStatus . "</td>";
                echo "<td><button type='submit' class='btn btn-info btn-xs btn-block bkUpdataBtn' data-toggle='modal' data-target='#Updata' id='" . $row['bkID'] . "'>修改</button></td>";
                echo "<td><button type='submit' class='btn btn-danger btn-xs btn-block bkDeleteBtn' data-toggle='modal' data-target='#DeleteBK' id='" . $row['bkID'] . "'>删除</button></td>";
                echo "</tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
    </div>
</div>
<!-- book 表 -->
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
<!-- #Update -->
<div class="modal fade" id="Updata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改书籍信息</h4>
            </div>
            <div class="modal-body">
                <form id="bkUpdataForm" method="POST">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" id="bkUpataSubmit">提交</button>
            </div>
        </div>
    </div>
</div>
<!-- #Updata -->
<!-- #Delete -->
<div class="modal fade" id="DeleteBK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">删除读者</h4>
            </div>
            <div class="modal-body">
                <p>你确定要删除该书籍吗？</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="bkDeleteSubmit">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- #Delete -->
<!-- #newReader -->
<div class="modal fade" id="newBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加读者</h4>
            </div>
            <div class="modal-body">
                <form id="bkAddForm">
                    <div class="form-group">
                        <label for="ibkID">书籍编号：</label>
                        <input class="form-control" type="text" id="ibkID" name="ibkID" value="2017004" required>
                    </div>
                    <div class="form-group">
                        <label for="ibkName">书籍名称：</label>
                        <input class="form-control" type="text" id="ibkName" name="ibkName" value="编译原理" required>
                    </div>
                    <div class="form-group">
                        <label for="ibkAuthor">作者：</label>
                        <input class="form-control" type="text" id="ibkAuthor" name="ibkAuthor" value="王生源" required>
                    </div>
                    <div class="form-group">
                        <label for="ibkPress">出版社：</label>
                        <input class="form-control" type="text" id="ibkPress" name="ibkPress" value="清华大学出版社" required>
                    </div>
                    <div class="form-group">
                        <label for="ibkPrice">价格：</label>
                        <input class="form-control" type="text" id="ibkPrice" name="ibkPrice" value="38.00" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" id="bkAddBtn">提交</button>
            </div>
        </div>
    </div>
</div>
<!-- #newReader -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    // 响应新增读者按钮
    // `ibkID`, `ibkName`, `ibkAuthor`, `ibkPress`, `ibkPrice`,
    $("#bkAddBtn").click(function (e) {
        var ibkID = $("#ibkID").val();
        var ibkName = $("#ibkName").val();
        var ibkAuthor = $("#ibkAuthor").val();
        var ibkPress = $("#ibkPress").val();
        var ibkPrice = $("#ibkPrice").val();
        $.post("bookInsert.php", {
            'bkID': parseInt(ibkID),
            'bkName': ibkName,
            'bkAuthor': ibkAuthor,
            'bkPress': ibkPress,
            'bkPrice': ibkPrice
        }, function (data) {
            $("#newReader").modal("hide");
            alert(data);
            window.location.reload();
        });
    })
    // 响应修改按钮
    $(".bkUpdataBtn").click(function (e) {
        var bkID = $(e.target).attr("id");
        $.post("bookSelect.php", {'bkID': parseInt(bkID)}, function (data) {
            $("#bkUpdataForm").html(data);
        });
    })
    // 响应提交修改按钮
    $("#bkUpataSubmit").click(function (e) {
        var bkID = $("#bkID").val();
        var bkName = $("#bkName").val();
        var bkAuthor = $("#bkAuthor").val();
        var bkPress = $("#bkPress").val();
        var bkPrice = $("#bkPrice").val();
        $.post("bookUpdata.php", {
            'bkID': parseInt(bkID),
            'bkName': bkName,
            'bkAuthor': bkAuthor,
            'bkPress': bkPress,
            'bkPrice': bkPrice
        }, function (data) {
            $("#Updata").modal("hide");
            alert(data);
            window.location.reload();
        });
    })
    // 响应删除按钮，获取要删除的对象
    var bkIDDelete = 0;
    $(".bkDeleteBtn").click(function (e) {
        bkIDDelete = $(e.target).attr("id");
    })
    // 响应删除确认按钮
    $("#bkDeleteSubmit").click(function (e) {
        $.post("bookDelete.php", {'bkID': parseInt(bkIDDelete)}, function (data) {
            alert(data);
            window.location.reload();
        });
    })
</script>
</body>

</html>