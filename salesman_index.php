<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Salesman</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container-fluid">
    <div class="col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="index.php">Home</a></li>
            <li role="presentation"><a href="index.php">Admin</a></li>
            <li role="presentation" class="active"><a href="index.php">Salesman</a></li>
            <li class="navbar-right" role="presentation"><a href="index.php">Sign Out</a></li>
        </ul>
    </div>
    <!-- just for tables -->
    <div class="col-md-6 col-md-offset-3">
        <br>
        <div class="lead">Welcome, <?php if(isset($_COOKIE['current_user']))
            {echo $_COOKIE['current_user'];}?></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>locks</td>
                    <td>stocks</td>
                    <td>barrels</td>
                    <td>date</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $id = $_REQUEST['id'];
                setcookie("id",$id);# set the cookie
                # $id = 1 ;
                $datafile = "commission.sqlite";
                # get all the table
                $query = "select * from sales where id=".$id;
                $db = new SQLite3($datafile);
                $result = $db->query($query);
                # echo $result->numColumns();
                # echo var_dump($result->fetchArray());
                if(!$result)
                    #echo "";
                    echo "<script>alert(\"null\")</script>";
                else
                    while($row = $result->fetchArray()){
                        # skip the -1 value
                        if($row['locks']==-1&&$row['stocks']==-1&&$row['barrels']==-1)
                            continue;
                        # echo the table
                        $out = "<tr>";
                        $out .= "<td>".$row['locks']."</td>"
                            ."<td>".$row['stocks']."</td>"
                            ."<td>".$row['barrels']."</td>"
                            ."<td>".$row['date']."</td>";
                        $out .= "</tr>";
                        echo $out;
                    }

                # get the min and the max

                $date = date("Y")."-".date("m");
                # var_dump($date);
                $query = "select * from sales where id='".$id."' and date like '".$date."%'";
                $result = $db->query($query);
                $locks_saled = 0;
                $stocks_saled = 0;
                $barrels_saled = 0;
                $disable = false;
                if(!$result){
                    echo "";
                    # something wrong
                }else{
                    while($row = $result->fetchArray()){
                        # if has -1 break;
                        if($row['locks']==-1&&$row['barrels']==-1&&$row['stocks']==-1){
                            $disable = true;
                            break;
                        }
                        $locks_saled += $row['locks'];
                        $barrels_saled += $row['barrels'];
                        $stocks_saled += $row['stocks'];
                    }
                    # if all left is zero
                    if($locks_saled==70&&$stocks_saled==80&&$barrels_saled==90)
                        $disable=true;
                }
                # done
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 col-md-offset-4 lead">Commission is <?php include_once("caculate_money.php");
        echo update_commission($id, 0);?>$ this month so far</div>
    <!-- just for the form -->
    <div class="col-md-2 col-md-offset-5">
        <form class="form-horizontal" onsubmit="return check()" action="salesman_commit.php" method="post">
            <label class="control-label">Locks</label>
            <input name="locks" id="locks" class="form-control" type="number" min="0" max=<?php echo 70-$locks_saled;?> required autofocus>
            <label class="control-label">Stocks</label>
            <input name="stocks" id="stocks" class="form-control" type="number" min="0" max=<?php echo 80-$stocks_saled;?> required>
            <label class="control-label">Barrels</label>
            <input name="barrels" id="barrels" class="form-control" type="number" min="0" max=<?php echo 90-$barrels_saled;?> required>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <br>
            <button class="btn btn-lg btn-primary btn-block" <?php if($disable){ echo 'disabled=disabled';}
                ?> type="submit">Commit</button>
            <br>
            <button id="end_submit" class="btn btn-lg btn-warning btn-block" <?php if($disable){ echo 'disabled=disabled';}
            ?> type="button">Submit -1</button>
        </form>
    </div>
    <!-- listen the end submit button -->
    <script type="text/javascript" language="javascript">
        function $(id){return document.getElementById(id)};
        $("end_submit").onclick = function(){
            // get the cookie
            location.href="salesman_commit.php?nid="+getId()+"&nlocks=-1&nstocks=-1&nbarrels=-1";
        }
        function getId(){
            var coo = document.cookie;
            var cookies =coo.split(";");
            for(var i=0;i<cookies.length;i++){
                var item = cookies[i].split("=");
                // get the key
                if("id"==item[0]){
                    return item[1];
                }
            }
        }
        function check(){
            var locks = document.getElementById("locks").value;
            var stocks = document.getElementById("stocks").value;
            var barrels = document.getElementById("barrels").value;
            if(locks==0&&stocks==0&&barrels==0){
                alert("can not be all 0");
                return false;
            }
            else
                return true;
        }
    </script>

</div> <!-- /container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>