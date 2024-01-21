<?php
    session_start();

    $host = "localhost"; // database host
    $username = "test"; // database username
    $password = "12345"; // database password
    $dbname = "sadna"; // database name
    
    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


if (isset($_GET['delete'])) {
    $id=$_GET['delete'];
    $user = $_SESSION['userName'];
    $sql = "DELETE FROM `workspaces` WHERE id=$id AND userName='$user'";
    $result = $conn->query($sql);
    if($result){
        header('location:Existworkspace.php');
    }else{
        die( $conn->connect_error);
    }
}
?>