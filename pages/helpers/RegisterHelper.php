<?php
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
if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    // perform the database insertion
    
    $sql = "INSERT INTO registrations (firstName, lastName, userName, email, pass)
    VALUES ('" .  ucwords(strtolower($firstName)) . "', '" . ucwords(strtolower($lastName)) . "', '$userName' ,'$email', '$pass')";
    if (mysqli_query($conn, $sql)) {
        header("Location: http://localhost/workshop/pages/Login.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>