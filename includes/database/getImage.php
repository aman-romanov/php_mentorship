<?php
    function getImage($conn){
            
        $sql = "SELECT *
                FROM task_17";
        $stmt = $conn->prepare($sql);
    
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>