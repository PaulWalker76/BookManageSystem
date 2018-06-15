<?php
require_once 'dbConn.php';
$bkID = $_POST['bkID'];
$sql = "SELECT * FROM `book` WHERE `bkID` = $bkID";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $rdType = '';
    echo "<div class='form-group'><label for='bkID'>图书编号：</label><input class='form-control' type='text' id='bkID' name='bkID' value='" . $row['bkID'] . "' disabled></div>";
    echo "<div class='form-group'><label for='bkName'>图书名称：</label><input class='form-control' type='text' id='bkName' name='bkName' value='" . $row['bkName'] . "' required></div>";
    echo "<div class='form-group'><label for='bkAuthor'>作者：</label><input class='form-control' type='text' id='bkAuthor' name='bkAuthor' value='" . $row['bkAuthor'] . "' required></div>";
    echo "<div class='form-group'><label for='bkPress'>出版社：</label><input class='form-control' type='text' id='bkPress' name='bkPress' value='" . $row['bkPress'] . "' required></div>";
    echo "<div class='form-group'><label for='bkPrice'>价格：</label><input class='form-control' type='text' id='bkPrice' name='bkPrice' value='" . $row['bkPrice'] . "' required></div>";
}
mysqli_close($conn);