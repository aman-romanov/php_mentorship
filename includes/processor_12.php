<?php
    session_start();
    require 'redirect.php';
    require 'database/pdo.php';

    if(empty($_POST["email"] || $_POST["password"])){
        $_SESSION['error'] = 'Введите почту и пароль';
        redirect('/marlin/20_tasks/task_12.php');
    } else {
        $conn = getPDO();
        $email = $_POST["email"];
        $password = $_POST["password"];
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT *
                FROM task_12
                WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row_num = $stmt->rowCount();
            if($row_num <= 0){

                $sql = "INSERT INTO task_12 (email, password)
                    VALUES (:email, :password)";

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_STR);

                $stmt->execute();

                $_SESSION['success'] = 'Запись добавлена';

                redirect('/marlin/20_tasks/task_12.php');
            }else{
                $_SESSION['error'] = 'Почтовый адрес уже зарегистрирован';
                redirect('/marlin/20_tasks/task_12.php');
            }
        }else{
            $_SESSION['error'] = 'Введите корректный почтовый адрес!';
            redirect('/marlin/20_tasks/task_12.php');
        }
        
    }
    
?>