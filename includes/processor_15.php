<?php
    session_start();
    require "redirect.php";
    require "database/pdo.php";

    $conn = getPDO();
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT *
            FROM task_12
            WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($user > 0){
            $hash = $user[0]['password'];
            if(password_verify($password, $hash)){
                $_SESSION['is_logged_in'] = true;
                redirect('/marlin/20_tasks/task_16.php');
            }else{
                $_SESSION['is_logged_in'] = false;
                redirect('/marlin/20_tasks/task_15.php');
            }
        }else{
            $_SESSION['is_logged_in'] = false;
            redirect('/marlin/20_tasks/task_15.php');
        }
    }else{
        $_SESSION['error'] = 'Введите корректный почтовый адрес!';
        redirect('/marlin/20_tasks/task_15.php');
    }
?>