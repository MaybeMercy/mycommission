<?php
/**
 * Created by PhpStorm.
 * User: Maybe霏
 * Date: 2015/4/7
 * Time: 9:45
 */
include_once("caculate_money.php");
$id = $_REQUEST['id'];
$locks = $_REQUEST['locks'];
$stocks = $_REQUEST['stocks'];
$barrels = $_REQUEST['barrels'];
$date = date("Y-m-d");

$db = new SQLite3("commission.sqlite");
$insert = "insert into sales values ('".$id."', $locks, $stocks, $barrels, '".$date."')";

$result = $db->exec($insert);

if(!$result){
    echo "<script>alert(\"wrong\")</script>";
}else{
    # if -1 skip
    if($locks==-1&&$stocks==-1&&$barrels==-1);
    else
        $result = update_commission($id, $locks*45+$stocks*30+$barrels*25);
    echo "<script>alert(\"success \"$result)</script>";
    # update the commission
}
echo "<script>location.href=\"salesman_index.php?id=".$id."\";</script>";

?>