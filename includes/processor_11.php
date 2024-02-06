<?php 
    session_start();
    require 'redirect.php';

    if(empty($_POST["simpleinput"])){
        $_SESSION['error'] = 'Заполните поле';
        redirect('/marlin/20_tasks/task_11.php');
    } else {
        $db_host = "localhost";
        $db_name = "marlin_tasks";
        $db_user = "tester";
        $db_pass = "vOJ1Cls7Q52GTIaT";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';
        $text = $_POST["simpleinput"];
        try {
            $conn = new PDO($dsn, $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo $e->getMessage();
            exit;
        }
        $sql = "SELECT *
                FROM task_10
                WHERE text = :text";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->execute();
        $row_num = $stmt->rowCount();
        if($row_num <= 0){

            $sql = "INSERT INTO task_10 (text)
                VALUES (:text)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':text', $text, PDO::PARAM_STR);

            $stmt->execute();

            $_SESSION['success'] = 'Запись добавлена';

            redirect('/marlin/20_tasks/task_11.php');
        }else{
            $_SESSION['error'] = 'Запись дублируется';
            redirect('/marlin/20_tasks/task_11.php');
        }
        
    }
    
?>