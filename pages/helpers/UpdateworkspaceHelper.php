
<head>
    <link rel="stylesheet" href="/workshop/CSS/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap"
      rel="stylesheet"
    />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WorkHouse</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="/workshop/pics/Logo.png" />
  </head>
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
session_start();

if (isset($_POST['submit'])) {
    $rowId = $_GET['id'];
    $region = $_POST['region'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $placeType = $_POST['placeType'];
    $rentalPeriod = $_POST['rentalPeriod'];
    $dailyPrice = $_POST['dailyPrice'];
    $ownerName = $_POST['ownerName'];
    $email = $_POST['email'];
    $imageData = file_get_contents($_FILES['pictures']['tmp_name']);
    $encodedImageData = base64_encode($imageData);
    $aboutWorkspace = $_POST['aboutWorkspace'];
    $userName = $_SESSION['userName'];
        // Insert form data into the database
        $sql = "UPDATE `workspaces` 
        SET 
        region = '$region',
        city='$city', 
        address='$address', 
        placeType='$placeType', 
        rentalPeriod='$rentalPeriod', 
        dailyPrice=$dailyPrice, 
        ownerName='$ownerName',
         email='$email',
         pictures='$encodedImageData',
         aboutWorkspace='$aboutWorkspace'
         WHERE id=$rowId AND userName='$userName';
         ";
        if ($conn->query($sql) === TRUE) {
            echo '<div class="container-fluid h-100 d-flex justify-content-center align-items-center fs-5" >';
            echo 'Thank you ,' . $_POST['ownerName'] . ' your workspace successfully updated ';
            echo '<button class="submit m-3 " onclick="location.href=\'/workshop/pages/Homepage.php\'">Back to the home page</button>';
            echo '</div>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
}
$conn->close();
?>