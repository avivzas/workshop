<?php
$ini = parse_ini_file('../../config.ini');

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

function isUsernameTaken($username, $conn) {
    $safeUsername = mysqli_real_escape_string($conn, $username);
    $query = "SELECT COUNT(*) AS count FROM registrations WHERE userName = '$safeUsername'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return ($count > 0);
    } else {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Check if the username is already taken
    if (isUsernameTaken($userName, $conn)) {
        echo '<script>
                    var errorMessage = "Username is already taken. Please choose a different one.";
                  </script>';
            // You may want to include a flag to show the error alert
            echo '<script>
                    var showErrorAlert = true;
                  </script>';
        }
     else {
        // Continue with the registration process
        $sql = "INSERT INTO registrations (firstName, lastName, userName, email, pass)
                VALUES ('" .  ucwords(strtolower($firstName)) . "', '" . ucwords(strtolower($lastName)) . "', '$userName' ,'$email', '$pass')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to the login page after successful registration
            header("Location: http://localhost/workshop/pages/Login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
<script>
      // Check if errorMessage variable is set
      if (typeof errorMessage !== "undefined" && showErrorAlert) {
        alert(errorMessage);
        window.location.href = "http://localhost/workshop/pages/Register.html";
        
      }
    </script>
