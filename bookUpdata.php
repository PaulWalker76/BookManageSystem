<?php
require_once 'dbConn.php';
$bkID = $_POST['bkID'];
$bkName = $_POST['bkName'];
$bkAuthor = $_POST['bkAuthor'];
$bkPress = $_POST['bkPress'];
$bkPrice = $_POST['bkPrice'];
$sql = "UPDATE `book` SET `bkID` = '$bkID', `bkName` = '$bkName', `bkAuthor` = '$bkAuthor', `bkPress` = '$bkPress', `bkPrice` = '$bkPrice' WHERE `book`.`bkID` = $bkID";
$result = mysqli_query($conn, $sql);
$rs = mysqli_affected_rows($conn);
if ($rs == 0) {
    echo "未产生更改";
} else if ($rs == -1) {
    echo "修改失败";
} else {
    echo "修改成功，影响 " . $rs . " 行数据。";
}
mysqli_close($conn);