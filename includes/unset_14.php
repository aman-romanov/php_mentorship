<?php 
    session_start();
    require 'redirect.php';

    session_unset();

    redirect('/marlin/20_tasks/task_14.php');
?>