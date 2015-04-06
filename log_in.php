<?php

/**
 * Created by PhpStorm.
 * User: Maybe霏
 * Date: 2015/4/6
 * Time: 8:50
 */

    $mail = $_POST['mail'];
    $psd = $_POST['psd'];

    # connect to the sql
    $datafile = "commission.sqlite";
    $query = "select * from user where mail='".$mail."' and psd='".$psd."'";
    $db = new SQLite3($datafile);
    $result = $db->query($query);
    if(!$result)
        header("index.php");#redirect
    else
        while($row = $result->fetchArray()){
            //
            $position = $row['position'];
            if($position==0)
                header("admin_index.php?id=".$row['id']);
            else
                header("salesman_index.php?id=".$row['id']);
            exit;
        }
?>