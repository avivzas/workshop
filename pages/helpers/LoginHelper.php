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
$userName = $_POST['userName'];
$pass = $_POST['pass'];

//query the database to retrieve user information
$query = "SELECT * FROM registrations WHERE userName='$userName'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 1) {
    //if the username is found in the database, verify the password
    $row = mysqli_fetch_assoc($result);
    if ($pass == $row['pass']) {
        //password is correct, create session variable and redirect to desired page
        session_start();
        $_SESSION['authenticated'] = true;
        $_SESSION['userName'] = $row['userName'];
        $_SESSION['firstName'] = $row['firstName'];
            header("Location: http://localhost/workshop/pages/Homepage.php");
            exit();
    }
}
$error = "Invalid password or username.";

header("Location: http://localhost/workshop/pages/Login.php?error=" . urlencode($error));
//close the database connection

mysqli_close($conn);