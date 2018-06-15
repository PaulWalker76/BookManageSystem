<?php
require_once 'dbConn.php';
$bkID = (int)($_POST['bkID']);
$sql = "SELECT `bkStatus` FROM `book` WHERE bkID = " . $bkID;
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    if ($row['bkStatus'] == 1) {
        $sql = "DELETE FROM `book` WHERE `bkID` =  " . $bkID;
        mysqli_query($conn, $sql);
        $rs = mysqli_affected_rows($conn);
        if ($rs == 0) {
            echo "未产生更改";
        } else if ($rs == -1) {
            echo "删除出错，该书籍不存在。";
        } else {
            echo "删除成功，影响 " . $rs . " 行数据。";
        }
    } else {
        echo "该书籍已借出，无法删除";
    }
}
mysqli_close($conn);