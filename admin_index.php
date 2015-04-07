<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Admin</title>

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
            <li role="presentation" class="active"><a href="#">Admin</a></li>
            <li role="presentation"><a href="index.php">Salesman</a></li>
            <li class="navbar-right" role="presentation"><a href="index.php">Sign Out</a></li>
        </ul>
    </div>
    <!-- just for tables-->
    <div class="col-md-6 col-md-offset-3">
        <br>
        <div class="col-md-4" action="admin_index.php">
            <select id="select_salesman" class="form-control">
                <?php
                    $datafile = "commission.sqlite";
                    $db = new SQLite3($datafile);
                    $query = "select * from user where position=1";
                    $result = $db->query($query);
                    $salesmanId = "";
                    # is request
                    if(isset($_REQUEST['salesmanId'])){
                        $salesmanId = $_REQUEST['salesmanId'];
                    }
                    if(!$result){
                        # error
                    }else{
                        while($row = $result->fetchArray()){
                            # if salesmanId is ""
                            if($salesmanId==""){
                                $salesmanId = $row['id'];
                            }
                            if($salesmanId==$row['id'])
                                $out .= "<option selected=selected value=".$row['id'].">".$row['mail']."</option>";
                            else
                                $out .= "<option value=".$row['id'].">".$row['mail']."</option>";
                        }
                    }
                    echo $out;
                ?>
            </select>
            <br>
            <button id="confirm_salesman" class="btn btn-default">Select</button>
            <br><br>
            <script type="text/javascript" language="javascript">

                $("confirm_salesman").onclick = function(){
                    // get the select
                    var id = document.getElementById("select_salesman").value;
                    alert(id);
                    // jump
                    location.href="admin_index.php?salesmanId="+id;
                }
                function $(id){
                    return document.getElementById(id)
                };

            </script>
        </div>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>nick</td>
                    <td>locks</td>
                    <td>stocks</td>
                    <td>barrels</td>
                    <td>date</td>
                </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_COOKIE['salesmanId'])){
                $id = $_COOKIE['salesmanId'];
            }else{

            }
            $id = $salesmanId;
            if($id=="") # if $id is ""
                return;
            $query = "select * from sales where id=".$id;
            $result = $db->query($query);
            if(!$result)
                echo "";
            else
                while($row = $result->fetchArray()){
                    // jump the end record
                    if($row['locks']==-1&&$row['stocks']==-1&&$row['barrels']==-1)
                        continue;
                    $out = "<tr>";
                    $out .= "<td>".'nick'."</td>"
                        ."<td>".$row['locks']."</td>"
                        ."<td>".$row['stocks']."</td>"
                        ."<td>".$row['barrels']."</td>"
                        ."<td>".$row['date']."</td>";
                    $out .= "</tr>";
                    echo $out;
                }
            ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>