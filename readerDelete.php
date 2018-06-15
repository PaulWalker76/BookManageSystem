<?php
require_once 'dbConn.php';
$rdID = (int)($_POST['rdID']);
$sql = "SELECT `rdBorrowQty` FROM `reader` WHERE rdID = " . $rdID;
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    if ($row['rdBorrowQty']) {
        echo "该读者书籍有书籍未归还，无法删除";
    } else {
        $sql = "DELETE FROM `reader` WHERE `rdID` =  " . $rdID;
        mysqli_query($conn, $sql);
        $rs = mysqli_affected_rows($conn);
        if ($rs == 0) {
            echo "未产生更改";
        } else {
            echo "删除成功，影响 " . $rs . " 行数据。";
        }
    }
}
mysqli_close($conn);