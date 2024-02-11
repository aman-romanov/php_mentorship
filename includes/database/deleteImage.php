<?php
    function deleteImage($conn, $id){
            
        $sql = "DELETE FROM task_17
                WHERE id = :id";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
?>