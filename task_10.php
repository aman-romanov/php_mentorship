<?php
    require "includes/db.php";
    $db = getDB();
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["simpleinput"])){
            $message = "Введите текст";
        } else {
            $text = $_POST["simpleinput"];
            $query="SELECT *
                    FROM task_10
                    WHERE text = ?";
            $result = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($result, 's', $text);
            mysqli_stmt_execute($result);
            mysqli_stmt_store_result($result);
            $rows = mysqli_stmt_num_rows($result);
            if ($rows<=0)
            {
                $sql = "INSERT INTO task_10(text)
                    VALUES (?)";
                $stmt = mysqli_prepare($db, $sql);
                mysqli_stmt_bind_param($stmt, 's', $text);
                mysqli_stmt_execute($stmt);
                $message = "Сохранено!";
            }else{
                $message = "Запись дублируется";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>
            Подготовительные задания к курсу
        </title>
        <meta name="description" content="Chartist.html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
        <link rel="stylesheet" media="screen, print" href="css/statistics/chartist/chartist.css">
        <link rel="stylesheet" media="screen, print" href="css/miscellaneous/lightgallery/lightgallery.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
    </head>
    <body class="mod-bg-1 mod-nav-link ">
        <main id="js-page-content" role="main" class="page-content">

            <div class="col-md-6">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Задание
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="panel-content">
                                <div class="form-group">
                                    <form action ="" method="post">
                                        <label class="form-label" for="simpleinput">Text</label>
                                        <?php if(!empty($message)): ?>
                                            <p><?=$message;?></p>
                                        <?php endif; ?>
                                        <input type="text" id="simpleinput" name="simpleinput" class="form-control">
                                        <button class="btn btn-success mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

        <script src="js/vendors.bundle.js"></script>
        <script src="js/app.bundle.js"></script>
        <script>
            // default list filter
            initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
            // custom response message
            initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
        </script>
    </body>
</html>
