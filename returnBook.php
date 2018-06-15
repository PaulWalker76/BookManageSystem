<?php
require_once 'dbConn.php';
$rdID = $_POST['rdID'];
$bkID = $_POST['bkID'];
$dateBorrow = $_POST['dateBorrow'];
$sql = "SET @p0 = '$rdID';";
$sql .= "SET @p1 = '$bkID';";
$sql .= "SET @p2 = '$dateBorrow';";
$sql .= "CALL `book_return`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);";
$sql .= "SELECT @p3 AS `p_today`, @p4 AS `p_exist`, @p5 AS `p_DateLendPlan`, @p6 AS `p_dateLendAct`, @p7 AS `p_message`;";
if (mysqli_multi_query($conn, $sql)) {
    do {
        // 存储第一个结果集
        if ($result = mysqli_store_result($conn)) {
            while ($row = mysqli_fetch_row($result)) {
                printf($row[4]);
            }
            mysqli_free_result($result);
        };
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
}
mysqli_close($conn);