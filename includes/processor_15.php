<?php
    session_start();
    require "redirect.php";

    $db_host = "localhost";
    $db_name = "marlin_tasks";
    $db_user = "tester";
    $db_pass = "vOJ1Cls7Q52GTIaT";

    $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

    try {
        $conn = new PDO($dsn, $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        echo $e->getMessage();
        exit;
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT *
            FROM task_12
            WHERE email = :email
            AND password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $row_num = $stmt->rowCount();
        if($row_num > 0){

            $_SESSION['is_logged_in'] = true;
            redirect('/marlin/20_tasks/task_16.php');
        }else{
            $_SESSION['is_logged_in'] = false;
            redirect('/marlin/20_tasks/task_15.php');
        }
    }else{
        $_SESSION['error'] = 'Введите корректный почтовый адрес!';
        redirect('/marlin/20_tasks/task_15.php');
    }
?>