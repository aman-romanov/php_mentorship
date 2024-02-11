<?php
    session_start();
    require "redirect.php";
    require "database/pdo.php";
    require "database/deleteImage.php";
    
    if(isset($_GET['id'])){

        $id = $_GET['id'];
        $conn = getPDO();
        $sql = "SELECT *
                FROM task_17
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if($image = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            if(deleteImage($conn, $id)){
                $destination = __DIR__ . '/../img/uploads/'. $image[0]['img'];
                if(file_exists($destination)){
                    unlink($destination . $image[0]['img']);
                    $_SESSION['success'] = "Изображение удалено";
                    redirect('/marlin/20_tasks/task_18.php');
                }else{
                    $_SESSION['error'] = "Изображение отсутствует";
                    redirect('/marlin/20_tasks/task_18.php'); 
                }
            }
        }else{
            $_SESSION['error'] = "Возникла ошибка";
            redirect('/marlin/20_tasks/task_18.php');
        }
    }else{
        $_SESSION['error'] = "Выберите фото";
        redirect('/marlin/20_tasks/task_18.php');
    }
?>