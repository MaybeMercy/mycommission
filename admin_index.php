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
        <div class="lead">Welcome <?php if(isset($_COOKIE['current_user'])){echo $_COOKIE['current_user'];}?></div>
        <div>
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
        <!-- for the table -->
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
            $id = $salesmanId;
            if($id=="") # if $id is ""
                return;
            $query = "select * from sales where id=".$id;
            $result = $db->query($query);
            $saled_locks = 0;
            $saled_stocks = 0;
            $saled_barrels = 0;
            if(!$result)
                echo "";
            else
                while($row = $result->fetchArray()){
                    // jump the end record
                    if($row['locks']==-1&&$row['stocks']==-1&&$row['barrels']==-1)
                        continue;
                    # saled
                    $saled_locks += $row['locks'];
                    $saled_stocks += $row['stocks'];
                    $saled_barrels += $row['barrels'];
                    # end
                    $out = "<tr>";
                    $out .= "<td>".$row['locks']."</td>"
                        ."<td>".$row['stocks']."</td>"
                        ."<td>".$row['barrels']."</td>"
                        ."<td>".$row['date']."</td>";
                    $out .= "</tr>";
                    echo $out;
                }
            $db->close();
            ?>
            </tbody>
        </table>
    </div>
    <!-- remind -->
    <div class="col-md-4 col-md-offset-4 lead">U should pay him <?php include_once("caculate_money.php");
            if($saled_locks==0||$saled_barrels==0||$saled_stocks==0)
                echo 0;
            else
                echo update_commission($id, 0);?>$ this month so far</div>
    <div id="chart" style="height: 400px"></div>
    <script src="js/echarts-all.js"></script>
    <script type="text/javascript">
        var myChart = echarts.init(document.getElementById('chart'),'green');
        myChart.setOption({
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['locks','stocks','barrels']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    splitArea : {show : true}
                }
            ],
            series : [
                {
                    name:'locks',
                    type:'bar',
                    data:[<?php echo get_sale($id, 'locks');?>]
                },
                {
                    name:'stocks',
                    type:'bar',
                    data:[<?php echo get_sale($id, 'stocks');?>]
                },
                {
                    name:'barrels',
                    type:'bar',
                    data:[<?php echo get_sale($id, 'barrels')?>]
                }
            ]
        }, 'green');

    </script>
</div> <!-- /container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>