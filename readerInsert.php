<?php
require_once 'dbConn.php';
$rdID = $_POST['irdID'];
$rdType = $_POST['irdType'];
$rdName = $_POST['irdName'];
$rdDept = $_POST['irdDept'];
$rdQQ = $_POST['irdQQ'];
$sql = "INSERT INTO `reader` (`rdID`, `rdType`, `rdName`, `rdDept`, `rdQQ`, `rdBorrowQty`) VALUES
($rdID, $rdType, '$rdName', '$rdDept', '$rdQQ', 0)";
$result = mysqli_query($conn, $sql);
$rs = mysqli_affected_rows($conn);
if ($rs == 0) {
    echo "未产生更改";
} else {
    echo "添加成功，影响 " . $rs . " 行数据。";
}
mysqli_close($conn);