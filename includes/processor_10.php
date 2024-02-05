<?php 
    require 'redirect.php';

    if(empty($_POST['simpleinput'])){
        echo "Введите текст";
    } else {
        $db_host = "localhost";
        $db_name = "marlin_tasks";
        $db_user = "tester";
        $db_pass = "vOJ1Cls7Q52GTIaT";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';
        $text = $_POST['simpleinput'];
        try {
            $conn = new PDO($dsn, $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO task_10 (text)
                VALUES (:text)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':text', $text, PDO::PARAM_STR);

            $stmt->execute();

            redirect('/marlin/20_tasks/task_10(2).php');
        } catch (PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }
    
?>