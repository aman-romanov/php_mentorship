<?php 
    session_start();
    require 'redirect.php';

    if(empty($_SESSION['click'])){
        $_SESSION['click'] = 0;
        $_SESSION['click'] ++;
    }else{
        $_SESSION['click'] ++;
    }

    redirect('/marlin/20_tasks/task_14.php');
?>