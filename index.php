<?php

session_start();
include "function.php";
require 'openid.php';

header("Content-Type:text/html; charset=utf-8");
try {
    $openid = new LightOpenID('http://localhost:8000/borrow');
    if (!$openid->mode) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $openid->identity = 'http://openid.ntpc.edu.tw/';
            $openid->required = array('namePerson/friendly', 'contact/email', 'namePerson', 'birthDate', 'person/gender', 'contact/postalCode/home', 'contact/country/home', 'pref/language', 'pref/timezone');
            header('Location: ' . $openid->authUrl());
        }

        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>目前已借用的資訊設備</title>
            <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
            <link href="css/styles.css" rel="stylesheet" >
        </head>
        <body>
        <p></p>

        <div class = "container">
            <div class = "jumbotron">


                目前已借用的資訊設備


                <form action="" method="post">
                    <input type="submit" class = "navbar-btn btn-info btn pull-right " value="借用資訊設備" />
                    <a href = "http://www.tsces.ntpc.edu.tw" class = "navbar-btn btn-primary btn pull-right">回首頁</a>

                </form>


            </div>
        </div>

        <div class = "container">


            <?php

            $panel_style = ['panel-success', 'panel-danger', 'panel-warning', 'panel-info'];

            $items = get_items();

            $num= 0;
            foreach($items as $item):

            ?>

            <?php if($num%4 === 0 ):?>
            <div class = "row">
            <?php endif; ?>

                <div class = "col-md-3">
                    <div class="panel <?=$panel_style[$num%4]?>">
                        <div class="panel-heading text-center"><?=$item[1]?></div>
                        <ul class="list-group my-listlink text-left">
                            <?=get_item_borrowed($item[1])?>
                        </ul>
                    </div>
                </div>


            <?php if( (count($items)-1)==$num or ($num%4) === 3 ):?>
            </div>
            <?php endif;?>

            <?php
                $num++;
            endforeach;
            ?>



            <script src="lib/jquery/jquery-1.11.0.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } elseif ($openid->mode == 'cancel') {
        echo '使用者取消';
    } else {
        if ($openid->validate()) {
            $attr = $openid->getAttributes();

            /*echo '<table border="1" cellspacing="0" cellpadding="10">';
            echo '<tr><td>帳號</td><td>' . end(array_values(explode('/', $openid->identity))) . '</td></tr>';
            echo '<tr><td>識別碼</td><td>' . $attr['contact/postalCode/home'] . '</td></tr>';
            echo '<tr><td>姓名</td><td>' . $attr['namePerson'] . '</td></tr>';
            echo '<tr><td>暱稱</td><td>' . $attr['namePerson/friendly'] . '</td></tr>';
            echo '<tr><td>性別</td><td>' . ($attr['person/gender'] == 'M' ? '男' : '女') . '</td></tr>';
            echo '<tr><td>出生年月日</td><td>' . $attr['birthDate'] . '</td></tr>';
            echo '<tr><td>公務信箱</td><td>' . $attr['contact/email'] . '</td></tr>';
            echo '<tr><td>單位</td><td>' . $attr['contact/country/home'] . '</td></tr>';
            echo '<tr><td>年級</td><td>' . substr($attr['pref/language'], 0, 2) . '</td></tr>';
            echo '<tr><td>班級</td><td>' . substr($attr['pref/language'], 2, 2) . '</td></tr>';
            echo '<tr><td>座號</td><td>' . substr($attr['pref/language'], 4, 2) . '</td></tr>';
            echo '</table>';
            echo '<p />';
            echo '<table border="1" cellspacing="0" cellpadding="10">';
            echo '<tr><td>單位代碼</td><td>單位名稱</td><td>身分別</td><td>職務別</td><td>職稱別</td></tr>';*/
            $_SESSION['cname'] = $attr['namePerson'];
            $_SESSION['teacherid'] = end(array_values(explode('/', $openid->identity)));
            foreach (json_decode($attr['pref/timezone']) as $item) {
                /*echo '<tr>';
                echo '<td>' . $item->id . '</td>';
                echo '<td>' . $item->name . '</td>';
                echo '<td>' . $item->role . '</td>';
                echo '<td>' . $item->title . '</td>';
                echo '<td>' . implode('、', $item->groups) . '</td>';
                echo '</tr>';*/

                $_SESSION['school'] = $item->id;
                $_SESSION['teacher'] = $item->name;
                $_SESSION['role'] =$item->role;
                $_SESSION['title'] =$item->title;


                /*echo $_SESSION['teacherid'];
                echo $_SESSION['school'];
                echo $_SESSION['teacher'];
                echo $_SESSION['c'];
                echo $_SESSION['cname'];*/

                $forward_url = chk_permission($_SESSION['school'], $_SESSION['title']);
                header('Location:' . $forward_url);

            }
            /*echo '</table>';*/
        }
    }
} catch (ErrorException $e) {
    echo $e->getMessage();
}