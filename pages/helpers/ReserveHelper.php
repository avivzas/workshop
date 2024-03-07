
<?php
session_start();
$ini = parse_ini_file('../../config.ini');

$host = $ini['db_host'];
$username = $ini['db_user'];
$password = $ini['db_password'];
$dbname = $ini['db_name'];

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $workspaceID = $_POST['workspaceID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName']; 
    $userName = $_POST['userName']; 

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO reservations (spaceID, startDate, endDate, userName, email, fullName) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $workspaceID, $startDate, $endDate, $userName, $email, $fullName);
    

    if ($stmt->execute()) {
        echo '<div class="container-fluid h-100 d-flex justify-content-center align-items-center fs-5">';
        echo 'Thank you ' . $_SESSION['firstName'] . ', your space has been reserved.';
        echo '<button class="submit m-3" onclick="location.href=\'/workshop/pages/Homepage.php\'">Back to the home page</button>';
        echo '</div>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

$conn->close();


?>