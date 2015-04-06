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
        return "nothing";
    else
        while($row = $result->fetchArray()){
            return $row['id'];
        }
?>