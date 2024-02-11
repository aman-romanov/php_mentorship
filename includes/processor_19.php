<?php
    session_start();
    require "redirect.php";
    require "database/pdo.php";
    require "database/setImage.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $number = count($_FILES['images']['name']);
        if(!empty($_FILES)){
            for( $i=0 ; $i < $number ; $i++ ) {
                switch($_FILES['images']['error'][$i]){
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $_SESSION['error'] = "Прикрепите файл";
                        redirect('/marlin/20_tasks/task_19.php');
                        exit;
                    case UPLOAD_ERR_INI_SIZE:
                        $_SESSION['error'] = "Размер изображения не должно превышать 2M";
                        redirect('/marlin/20_tasks/task_19.php');
                        exit;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $_SESSION['error'] = "Папка не найдена";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $_SESSION['error'] = "Изображение не переместилось";
                        break;
                    default:
                        $_SESSION['error'] = "Возникла ошибка";
                        break;
                }
                $mime_types = ['image/jpg', 'image/jpeg', 'image/png'];
                if ($_FILES['images']['tmp_name'][$i]>0){
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES['images']['tmp_name'][$i]);
                    if(!in_array($mime_type, $mime_types)){
                        $_SESSION['error'] = "Изображение должно соответствовать форматам: jpeg/jpg/png";
                        redirect('/marlin/20_tasks/task_19.php');
                        exit;
                    } else{
                        $pathinfo = pathinfo($_FILES['images']['name'][$i]);
                        $base = $pathinfo['filename'];
                        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
                        $filename = $base . "." . $pathinfo['extension'];
                        $destination = __DIR__ . '/../img/uploads/' . $filename;

                        $n = 1;
                        while(file_exists($destination)){
                            $filename = $base . "($n)." . $pathinfo['extension'];
                            $destination = __DIR__ . '/../img/uploads/' . $filename;

                            $n++;
                        }
                        
                        if(!move_uploaded_file($_FILES['images']['tmp_name'][$i], $destination)){
                            $_SESSION['error'] = "Возникла ошибка";
                            redirect('/marlin/20_tasks/task_19.php');
                        }else{
                            $conn = getPDO();
                            setImage($conn, $filename);
                        }
                    }
                }else{
                    $_SESSION['error'] = "Изображение должно соответствовать форматам: jpeg/jpg/png";
                    redirect('/marlin/20_tasks/task_19.php');
                }
            }
            $_SESSION['success'] = 'Файл загружен';
            redirect('/marlin/20_tasks/task_19.php');
            
        }else{
            $_SESSION['error'] = "Прикрепите файл";
            redirect('/marlin/20_tasks/task_19.php');
        }
    }
?>