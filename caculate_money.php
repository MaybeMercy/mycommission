<?php
/**
 * Created by PhpStorm.
 * User: Maybe霏
 * Date: 2015/4/7
 * Time: 19:52
 */
# caculate the money
function caculate_money($money){

    if($money<=1000)
        $commission = $money*0.1;
    else if($money>1000 && $money<=1800)
        $commission = 1000*0.1+($money-1000)*0.15;
    else
        $commission = 1000*0.1+800*0.15+($money-1800)*0.2;
    return $commission;

}

# update the commission db
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
        if(!$row['money']&&$row['money']!=0)
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
    $db->close();
}

# get the sales of the type
function get_sale($id, $type){
    $db = new SQLite3("commission.sqlite");
    $out = "";
    for($i=1;$i<=12;$i++){
        $num = 0;
        if($i<10)
            $date = date('Y')."-0".$i;
        else
            $date = date('Y')."-".$i;
        $select = "select * from sales where id='".$id."' and date like '".$date."%'";
        $result = $db->query($select);
        if(!$result){
            # error
            return "error";
        }else{
            while($row = $result->fetchArray()){
                if($row[$type]!=-1) # if -1 skip
                    $num += $row[$type];
            }
        }
        if($i<12)
            $out .= $num.",";
        else
            $out .= $num;
    }
    $db->close();
    return $out;
}
?>