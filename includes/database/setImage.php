<?php
    function setImage($conn, $filename){
        
    $sql = "INSERT INTO task_17 (img)
            VALUES (:image)";
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':image', $filename, PDO::PARAM_STR);

    return $stmt->execute();
    }
?>