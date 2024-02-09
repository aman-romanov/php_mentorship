<?php
    require "redirect.php";
    session_unset();
    unset($_SESSION['is_logged_in']);

    redirect('/marlin/20_tasks/task_15.php');
?>