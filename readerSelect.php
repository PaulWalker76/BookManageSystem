<?php
require_once 'dbConn.php';
$rdID = $_POST['rdID'];
$sql = "SELECT * FROM `reader` WHERE `rdID` = $rdID";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $rdType = '';
    echo "
    <div class='form-group'>
        <label for='rdID'>读者编号：</label>
        <input class='form-control' type='text' id='rdID' name='rdID' value='" . $row['rdID'] . "' disabled>
    </div>
    ";
    echo "
    <div class='form-group'>
        <label for='rdType'>读者类型：</label>
        <select class='form-control' id='rdType' name='rdType'>
    ";
    switch ($row['rdType']) {
        case 1:
            echo "
        <option value='1' selected = 'selected'>教师</option>
        <option value='2'>本科生</option>
        <option value='3'>硕士研究生</option>
        <option value='4'>博士研究生</option>";;
            break;
        case 2:
            echo "
        <option value='1'>教师</option>
        <option value='2' selected = 'selected'>本科生</option>
        <option value='3'>硕士研究生</option>
        <option value='4'>博士研究生</option>";
            break;
        case 3:
            echo "
        <option value='1'>教师</option>
        <option value='2'>本科生</option>
        <option value='3' selected = 'selected'>硕士研究生</option>
        <option value='4'>博士研究生</option>";;
            break;
        case 4:
            echo "
        <option value='1'>教师</option>
        <option value='2'>本科生</option>
        <option value='3'>硕士研究生</option>
        <option value='4' selected = 'selected'>博士研究生</option>";
            break;
    }
    echo "
        </select>
    </div>
    ";
    echo "
    <div class='form-group'>
        <label for='rdName'>读者姓名：</label>
        <input class='form-control' type='text' id='rdName' name='rdName' value='" . $row['rdName'] . "' required>
    </div>
    ";
    echo "
    <div class='form-group'>
        <label for='rdDept'>所在部门：</label>
        <input class='form-control' type='text' id='rdDept' name='rdDept' value='" . $row['rdDept'] . "' required>
    </div>
    ";
    echo "
    <div class='form-group'>
        <label for='rdQQ'>联系QQ：</label>
        <input class='form-control' type='text' id='rdQQ' name='rdQQ' value='" . $row['rdQQ'] . "' required>
    </div>
    ";
}
mysqli_close($conn);