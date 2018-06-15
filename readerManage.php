<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>读者管理 - 图书管理系统</title>
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
                    <a href="#" data-toggle="modal" data-target="#newReader">添加读者</a>
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
<!-- reader 表 -->
<div class="container">
    <div class="table-responsive">
        <table class='table table-responsive table-bordered table-hover'>
            <tr id="allReader">
                <th>读者编号</th>
                <th>读者类型</th>
                <th>读者姓名</th>
                <th>所在部门</th>
                <th>联系QQ</th>
                <th>已借书数量</th>
                <th colspan="2" class="text-center">操作</th>
            </tr>
            <?php
            require_once 'dbConn.php';
            $sql = "SELECT * FROM `reader`";
            $result = mysqli_query($conn, $sql);
            $rdType = "";
            while ($row = mysqli_fetch_array($result)) {
                switch ($row['rdType']) {
                    case 1:$rdType = "教师";break;
                    case 2:$rdType = "本科生";break;
                    case 3:$rdType = "硕士研究生";break;
                    case 4:$rdType = "博士研究生";break;
                    default:$rdType = "未定义";
                }
                echo "<tr>";
                echo "<td>" . $row['rdID'] . "</td>";
                echo "<td>" . $rdType . "</td>";
                echo "<td>" . $row['rdName'] . "</td>";
                echo "<td>" . $row['rdDept'] . "</td>";
                echo "<td>" . $row['rdQQ'] . "</td>";
                echo "<td>" . $row['rdBorrowQty'] . "</td>";
                echo "<td><button type='submit' class='btn btn-info btn-xs btn-block rdUpdataBtn' data-toggle='modal' data-target='#Updata' id='" . $row['rdID'] . "'>修改</button></td>";
                echo "<td><button type='submit' class='btn btn-danger btn-xs btn-block rdDeleteBtn' data-toggle='modal' data-target='#DeleteRD' id='" . $row['rdID'] . "'>删除</button></td>";
                echo "</tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
    </div>
</div>
<!-- reader 表 -->
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
                <h4 class="modal-title" id="myModalLabel">修改学生信息</h4>
            </div>
            <div class="modal-body">
                <form id="rdUpdataForm" method="POST">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" id="rdUpataSubmit">提交</button>
            </div>
        </div>
    </div>
</div>
<!-- #Updata -->
<!-- #Delete -->
<div class="modal fade" id="DeleteRD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">删除读者</h4>
            </div>
            <div class="modal-body">
                <p>你确定要删除该读者吗？</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="rdDeleteSubmit">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- #Delete -->
<!-- #newReader -->
<div class="modal fade" id="newReader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加读者</h4>
            </div>
            <div class="modal-body">
                <form id="rdAddForm">
                    <div class="form-group">
                        <label for="irdID">读者编号：</label>
                        <input class="form-control" type="text" id="irdID" name="irdID" value="2017110" required>
                    </div>
                    <div class="form-group">
                        <label for="irdType">读者类型：</label>
                        <select class="form-control" id="irdType" name="irdType" required>
                            <option value="1">教师</option>
                            <option value="2" selected="selected">本科生</option>
                            <option value="3">硕士研究生</option>
                            <option value="4">博士研究生</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="irdName">读者姓名：</label>
                        <input class="form-control" type="text" id="irdName" name="irdName" value="陈翔" required>
                    </div>
                    <div class="form-group">
                        <label for="irdDept">所在部门：</label>
                        <input class="form-control" type="text" id="irdDept" name="irdDept" value="计算机科学学院" required>
                    </div>
                    <div class="form-group">
                        <label for="irdQQ">联系QQ：</label>
                        <input class="form-control" type="text" id="irdQQ" name="irdQQ" value="23333333" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block" id="rdAddBtn">提交</button>
            </div>
        </div>
    </div>
</div>
<!-- #newReader -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    // 响应新增读者按钮
    $("#rdAddBtn").click(function (e) {
        var irdID = $("#irdID").val();
        var irdType = $("#irdType").val();
        var irdName = $("#irdName").val();
        var irdDept = $("#irdDept").val();
        var irdQQ = $("#irdQQ").val();
        $.post("readerInsert.php", {
            'irdID': parseInt(irdID),
            'irdType': irdType,
            'irdName': irdName,
            'irdDept': irdDept,
            'irdQQ': irdQQ
        }, function (data) {
            $("#newReader").modal("hide");
            alert(data);
            window.location.reload();
        });
    })
    // 响应修改按钮
    $(".rdUpdataBtn").click(function (e) {
        var rdID = $(e.target).attr("id");
        $.post("readerSelect.php", {'rdID': parseInt(rdID)}, function (data) {
            $("#rdUpdataForm").html(data);
        });
    })
    // 响应提交修改按钮
    $("#rdUpataSubmit").click(function (e) {
        var rdID = $("#rdID").val();
        var rdType = $("#rdType").val();
        var rdName = $("#rdName").val();
        var rdDept = $("#rdDept").val();
        var rdQQ = $("#rdQQ").val();
        $.post("readerUpdata.php", {
            'rdID': parseInt(rdID),
            'rdType': rdType,
            'rdName': rdName,
            'rdDept': rdDept,
            'rdQQ': rdQQ
        }, function (data) {
            $("#Updata").modal("hide");
            alert(data);
            window.location.reload();
        });
    })
    // 响应删除按钮，获取要删除的对象
    var rdIDDelete = 0;
    $(".rdDeleteBtn").click(function (e) {
        rdIDDelete = $(e.target).attr("id");
    })
    // 响应删除确认按钮
    $("#rdDeleteSubmit").click(function (e) {
        $.post("readerDelete.php", {'rdID': parseInt(rdIDDelete)}, function (data) {
            alert(data);
            window.location.reload();
        });
    })
    // 1. AJAX 方式异步传递参数
    // $.ajax({
    //     'url': 'readerPDO.php',
    //     'data': { 'op': 'select', 'rdID': parseInt(rdID) },
    //     'success': function (data) {
    //         $("#rdUpdataForm").html(data);
    //     },
    //     'dataType': 'html',
    //     'type': 'post'
    // });
</script>
</body>

</html>