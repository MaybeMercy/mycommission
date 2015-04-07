<?php
/**
 * Created by PhpStorm.
 * User: Maybe霏
 * Date: 2015/4/7
 * Time: 9:45
 */
$id = $_REQUEST['nid'];
$locks = $_REQUEST['nlocks'];
$stocks = $_REQUEST['nstocks'];
$barrels = $_REQUEST['nbarrels'];
$date = date("Y-m-d");

$dbfile = "commission.sqlite";
$db = new SQLite3($dbfile);
$insert = "insert into sales values ('".$id."', $locks, $stocks, $barrels, '".$date."')";

$result = $db->exec($insert);

if(!$result){
    echo "<script>alert(\"wrong\")</script>";
}else{
    echo "<script>alert(\"success\")</script>";
}
echo "<script>location.href=\"salesman_index.php?id=".$id."\";</script>";

?>