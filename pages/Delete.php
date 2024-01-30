<?php
    session_start();

    $ini = parse_ini_file('../config.ini');

    $host = $ini['db_host']; // database host
    $username = $ini['db_user']; // database username
    $password = $ini['db_password']; // database password
    $dbname = $ini['db_name']; // database name
    
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