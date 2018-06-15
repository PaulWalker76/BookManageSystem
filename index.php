<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>首页 - 图书管理系统</title>
    <link rel="icon" href="http://localhost/BMS/images/1.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="http://localhost/BMS/images/1.ico" type="image/x-icon"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<style>
    #search {
        padding: 30px 0px 200px 0px;
    }
</style>

<body>
<!-- 导航模块 -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
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
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="./bookManage.php">书籍管理</a></li>
                <li><a href="./readerManage.php">读者管理</a></li>
                <li><a href="./borrowManage.php">借阅管理</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#About">关于</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- 导航模块 -->
<!-- 图书检索 -->
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <img class="img-responsive" id="logo" src="./images/1.png" alt="图书检索LOGO">
        </div>
        <div class="col-md-4"></div>
    </div>
    <form id="search" action="./bookManage.php" method="get">
        <div class="row">
            <div class="col-md-2 form-group">
                <select class="form-control" id="items" name="items">
                    <option value="bkID">图书编号</option>
                    <option value="bkName">书籍名称</option>
                    <option value="bkAuthor">作者</option>
                    <option value="bkPress">出版社</option>
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
</div>
<!-- 图书检索 -->
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
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>
