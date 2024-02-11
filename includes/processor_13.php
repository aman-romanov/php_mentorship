<?php 
    session_start();
    require 'redirect.php';
    require 'database/pdo.php';

    if(empty($_POST["simpleinput"])){
        $_SESSION['error'] = 'Заполните поле';
        redirect('/marlin/20_tasks/task_13.php');
    } else {
        $conn = getPDO();
        $text = $_POST["simpleinput"];
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

            $_SESSION['text'] = $text;

            redirect('/marlin/20_tasks/task_13.php');
        }else{
            $_SESSION['error'] = 'Запись дублируется';
            redirect('/marlin/20_tasks/task_13.php');
        }
        
    }
    
?>