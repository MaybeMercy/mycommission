<?php
/**
 * Created by PhpStorm.
 * User: Maybe霏
 * Date: 2015/4/7
 * Time: 19:52
 */
function caculate_money($money){

    if($money<=1000)
        $commission = $money*0.1;
    else if($money>1000 && $money<=1800)
        $commission = 1000*0.1+($money-1000)*0.15;
    else
        $commission = 1000*0.1+800*0.15+($money-1800)*0.2;
    return $commission;

}

function update_commission($id, $money){
    $db = new SQLite3("commission.sqlite");
    $date = date('Y')."-".date('m');
    $query = "select * from commission where id='".$id."' and date='".$date."'";
    $result = $db->query($query);
    $origin_money = 0;
    if(!$result){
        # null and nothing
        return "select error";
    }else{
        # nothing in db, so insert into init
        $row = $result->fetchArray();
        if(!$row['money'])
        {
            $origin_money = 0;
            $insert = "insert into commission values('".$id."', '".$date."', 0, 0)";
            $result = $db->exec($insert);
            # failed
            if(!$result)
                return;
        }else{
            $origin_money = $row['money'];
        }

    }

    $origin_money += $money;
    $com = caculate_money($origin_money);

    $update = "update commission set commission=$com, money=$origin_money where id='".$id."' and date='".$date."'";
    $result = $db->exec($update);
    if(!$result)
        return "update error";
    else
        return $com;
}
?>