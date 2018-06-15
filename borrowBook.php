<?php
require_once 'dbConn.php';
$rdID = $_POST['rdID'];
$bkID = $_POST['bkID'];
$sql = "SET @p_rdID = '$rdID';";
$sql .= "SET @p_bkID = '$bkID';";
$sql .= "CALL `book_borrow`(@p_rdID,@p_bkID,@p2,@p3,@p4,@p5,@p6,@p7,@p8);";
$sql .= "SELECT @p2 AS `p_DateBorrow`,@p3 AS `p_bkStatus`,@p4 AS `p_rdBorrowQty`,@p5 AS `p_canLendQty`,@p6 AS `p_canLendDay`,@p7 AS `p_DateLendPlan`,@p8 AS `p_message`;";
if (mysqli_multi_query($conn, $sql)) {
    do {
        // 存储第一个结果集
        if ($result = mysqli_store_result($conn)) {
            while ($row = mysqli_fetch_row($result)) {
                printf($row[6]);
            }
            mysqli_free_result($result);
        };
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
}
mysqli_close($conn);