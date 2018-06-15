<?php
require_once 'dbConn.php';
$bkID = $_POST['bkID'];
$bkName = $_POST['bkName'];
$bkAuthor = $_POST['bkAuthor'];
$bkPress = $_POST['bkPress'];
$bkPrice = $_POST['bkPrice'];
$sql = "INSERT INTO `book` (`bkID`, `bkName`, `bkAuthor`, `bkPress`, `bkPrice`, `bkStatus`) VALUES
($bkID, '$bkName', '$bkAuthor', '$bkPress', '$bkPrice', 1)";
$result = mysqli_query($conn, $sql);
$rs = mysqli_affected_rows($conn);
if ($rs == 0) {
    echo "未产生更改";
} else if ($rs == -1) {
    echo "数据冲突，插入失败！";
} else {
    echo "添加成功，影响 " . $rs . " 行数据。";
}
mysqli_close($conn);