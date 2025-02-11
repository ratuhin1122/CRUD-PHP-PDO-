<?php

require_once('connection.php');

if($_GET['delete']){
    $roll = $_GET['delete'];
    $sql = "DELETE  FROM student WHERE roll = :roll";
    $result = $conn->prepare($sql);
    $result->bindParam(':roll', $roll);
    if( $result->execute()){
    header('Location: dashboard.php');
    } else {
        echo "Error deleting record";
    }
    

}

?>