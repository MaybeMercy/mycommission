<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Commission</title>

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
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                Dropdown
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
            </ul>
        </div>
        <br>
        <table class="table table-bordered">
            <tr>
                <td>nick</td>
                <td>locks</td>
                <td>stocks</td>
                <td>barrels</td>
                <td>date</td>
            </tr>
            <?php
            $id = 2;
            $datafile = "commission.sqlite";
            $query = "select * from salesman where id=".$id;
            $db = new SQLite3($datafile);
            $result = $db->query($query);
            if(!$result)
                echo "";
            else
                while($row = $result->fetchArray()){
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
        </table>
    </div>
</div> <!-- /container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>