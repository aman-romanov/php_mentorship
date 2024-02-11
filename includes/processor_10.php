<?php 
    require 'redirect.php';
    require 'database/pdo.php';

    if(empty($_POST['simpleinput'])){
        echo "Введите текст";
    } else {
        $conn = getPDO();
        $text = $_POST['simpleinput'];
        $sql = "INSERT INTO task_10 (text)
            VALUES (:text)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':text', $text, PDO::PARAM_STR);

        $stmt->execute();

        redirect('/marlin/20_tasks/task_10(2).php');
    }
    
?>