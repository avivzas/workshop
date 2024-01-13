<?php
$host = "localhost"; // database host
$username = "test"; // database username
$password = "12345"; // database password
$dbname = "sadna"; // database name

// Create connection
$connection = new mysqli($host, $username, $password, $dbname);

$userName = $_POST['userName'];

// Query the database to check if the username already exists
$result = mysqli_query($connection, "SELECT * FROM registrations WHERE userName = '$userName'");

if (mysqli_num_rows($result) > 0) {
    echo 'taken';
} else {
    echo 'available';
}
?>
