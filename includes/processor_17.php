<?php
    session_start();
    require "redirect.php";
    require "database/pdo.php";
    require "database/setImage.php";


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty($_FILES)){
            switch($_FILES['image']['error']){
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $_SESSION['error'] = "Прикрепите файл";
                    redirect('/marlin/20_tasks/task_17.php');
                    exit;
                case UPLOAD_ERR_INI_SIZE:
                    $_SESSION['error'] = "Размер изображения не должно превышать 2M";
                    redirect('/marlin/20_tasks/task_17.php');
                    exit;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $_SESSION['error'] = "Папка не найденa";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $_SESSION['error'] = "Изображение не переместилось";
                    break;
                default:
                    $_SESSION['error'] = "Возникла ошибка";
                    break;
            }

            $mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
            if($_FILES['image']['tmp_name']>0){
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
                if(!in_array($mime_type, $mime_types)){
                    $_SESSION['error'] = "Изображение должно соответствовать форматам: jpeg/jpg/png";
                    redirect('/marlin/20_tasks/task_17.php');
                } else{
                    $pathinfo = pathinfo($_FILES['image']['name']);
                    $base = $pathinfo['filename'];
                    $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
                    $filename = $base . "." . $pathinfo['extension'];
                    $destination = __DIR__ . '/../img/uploads/' . $filename;

                    $i = 1;
                    while(file_exists($destination)){
                        $filename = $base . "($i)." . $pathinfo['extension'];
                        $destination = __DIR__ . '/../img/uploads/' . $filename;

                        $i++;
                    }
                    
                    if(!move_uploaded_file($_FILES['image']['tmp_name'], $destination)){
                        $_SESSION['error'] = "Возникла ошибка";
                        redirect('/marlin/20_tasks/task_17.php');
                    }else{
                        $conn = getPDO();
                        if(setImage($conn, $filename)){
                            $_SESSION['success'] = 'Файл загружен';
                            redirect('/marlin/20_tasks/task_17.php');
                        }
                    }
                }
            }else{
                $_SESSION['error'] = "Изображение должно соответствовать форматам: jpeg/jpg/png";
                redirect('/marlin/20_tasks/task_17.php');
            } 
        }else{
            $_SESSION['error'] = "Прикрепите файл";
            redirect('/marlin/20_tasks/task_17.php');
        }
    }else{
        $_SESSION['error'] = "Прикрепите файл";
        redirect('/marlin/20_tasks/task_17.php');
    }
?>