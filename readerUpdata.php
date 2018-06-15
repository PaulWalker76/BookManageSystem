<?php
require_once 'dbConn.php';
$rdID = $_POST['rdID'];
$rdType = $_POST['rdType'];
$rdName = $_POST['rdName'];
$rdDept = $_POST['rdDept'];
$rdQQ = $_POST['rdQQ'];
$sql = "UPDATE `reader` SET `rdType` = '$rdType', `rdName` = '$rdName', `rdDept` = '$rdDept', `rdQQ` = '$rdQQ' WHERE `reader`.`rdID` = $rdID";
$result = mysqli_query($conn, $sql);
$rs = mysqli_affected_rows($conn);
if ($rs == 0) {
    echo "未产生更改";
} else {
    echo "修改成功，影响 " . $rs . " 行数据。";
}
mysqli_close($conn);
// 警告框功能模块
// echo "
// <div class='alert alert-warning alert-dismissible' role='alert'>
// <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
// <strong>提示!</strong>信息未更改
// </div>
// ";
// echo "
// <div class='alert alert-success alert-dismissible' role='alert'>
// <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
// <strong>提示!</strong>修改成功，影响 " . $rs . " 行数据。
// </div>
// ";
