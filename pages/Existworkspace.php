<?php
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
session_start();

// Function to update workspace reservation status
function updateWorkspaceReservationStatus($conn) {
  $today = date('Y-m-d'); // Today's date in 'YYYY-MM-DD' format

  // First, set reserved to 0 for workspaces with past reservations
  $sqlPast = "SELECT spaceId FROM reservations WHERE endDate < ? AND spaceId IN (SELECT id FROM workspaces WHERE reserved = 1)";
  $stmtPast = $conn->prepare($sqlPast);
  $stmtPast->bind_param("s", $today);
  $stmtPast->execute();
  $resultPast = $stmtPast->get_result();

  while ($rowPast = $resultPast->fetch_assoc()) {
      $spaceId = $rowPast['spaceId'];
      $updateSqlPast = "UPDATE workspaces SET reserved = 0 WHERE id = ?";
      $updateStmtPast = $conn->prepare($updateSqlPast);
      $updateStmtPast->bind_param("i", $spaceId);
      $updateStmtPast->execute();
      $updateStmtPast->close();
  }

  $stmtPast->close();

  // Then, set reserved to 1 for workspaces with future reservations
  $sqlFuture = "SELECT spaceId FROM reservations WHERE endDate >= ? AND spaceId IN (SELECT id FROM workspaces WHERE reserved = 0)";
  $stmtFuture = $conn->prepare($sqlFuture);
  $stmtFuture->bind_param("s", $today);
  $stmtFuture->execute();
  $resultFuture = $stmtFuture->get_result();

  while ($rowFuture = $resultFuture->fetch_assoc()) {
      $spaceId = $rowFuture['spaceId'];
      $updateSqlFuture = "UPDATE workspaces SET reserved = 1 WHERE id = ?";
      $updateStmtFuture = $conn->prepare($updateSqlFuture);
      $updateStmtFuture->bind_param("i", $spaceId);
      $updateStmtFuture->execute();
      $updateStmtFuture->close();
  }
  $stmtFuture->close();

    // Additionally, set reserved to 0 for workspaces without any active reservations
    $sqlNoMatch = "UPDATE workspaces SET reserved = 0 WHERE id NOT IN (SELECT spaceId FROM reservations WHERE endDate >= ?)";
    $stmtNoMatch = $conn->prepare($sqlNoMatch);
    $stmtNoMatch->bind_param("s", $today);
    $stmtNoMatch->execute();
    $stmtNoMatch->close();
}
// Update workspace reservation status before displaying them
updateWorkspaceReservationStatus($conn);
?>


<!DOCTYPE html>
<html lang="en">
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <link rel="icon" href="/workshop/pics/Logo.png" />
    
  </head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
      <div class="container-fluid bg-body ">
        <h1 class="logo">WorkHouse</h1>
        <button
          class="navbar-toggler "
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse bg-body" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active p-3" aria-current="page" href="Homepage.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle p-3"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                My Workspaces
              </a>
              <ul class="dropdown-menu dropdown-menu-dark ">
                <li>
                  <a class="dropdown-item" href="Addworkspace.php">Create new workspace</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Exists workspaces</a>
                </li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle p-3"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Reservations
              </a>
              <ul class="dropdown-menu dropdown-menu-dark">
                <li>
                  <a class="dropdown-item" href="#">Search new workspace</a>
                </li>
                <li>
                  <a class="dropdown-item" href="ExistReservations.php">Exists Reservations</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link p-3" href="mailto:SystemManager@WorkHouse.com">Contact Us</a>
            </li>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle p-3"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
            <img src="/workshop/pics/profile_pic.png" alt="Profile Pic" width="30" height="30">
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li>
                <a class="dropdown-item" href="EditProfile.php">Edit profile</a>
              </li>
              <li>
                <a class="dropdown-item" href="Login.php">Sign Out</a>
              </li>
            </ul>
          </li>
          </ul>
        </div>
      </div>
    </nav>

<div class="container-fluid p-0 m-0 ">


<div class="d-flex justify-content-center align-items-center m-0  pt-5 pb-0 ">
    <h1 class="greeting">My Workspaces</h1></div>

<button class="btn btn-primary my-5 mx-5  "> <a href="Addworkspace.php" class="text-light"> Add New Workspace </a></button> 


<table class="table m-0 p-0">
  <thead>
    <tr>
      <th scope="col">Region</th>
      <th scope="col">City</th>
      <th scope="col">Address</th>
      <th scope="col">Place Type</th>
      <th scope="col">Daily price</th>
      <th scope="col">Picture</th>
      <th scope="col">About</th>
      <th scope="col">reserved</th>
      <th scope="col">Options</th>
    </tr>


  </thead> 

  <tbody>

  <?php

    $user = $_SESSION['userName'];
    $sql = "SELECT * FROM `workspaces` WHERE userName='$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Output data from each row
        while ($row = $result->fetch_assoc()) {
            $rowId = $row['id'];
            $region = $row['region'];
            $city=$row['city'];
            $address=$row['address'];
            $placeType=$row['placeType'];
            $dailyPrice=$row['dailyPrice'];
            $ownerName=$row['ownerName'];
            $email=$row['email'];
            $imageData = base64_decode($row['pictures']);
            $imageSrc = "data:image/jpeg;base64," . base64_encode($imageData);
            $aboutWorkspace=$row['aboutWorkspace'];
            $reserved=$row['reserved'];
            


            echo "<tr>
            <th scope='row'> $region </th>
            <td>$city</td>
            <td>$address</td>
            <td>$placeType</td>
            <td>$dailyPrice</td>
            <td><img src='$imageSrc' alt='Workspace Image' width='200' height='200'></td>
            <td>$aboutWorkspace</td>
            <td>" . ($reserved == 0 ? "no" : "yes") . "</td>";
            
    if($reserved != 0) {
        echo "<td>

                  <button class='btn btn-primary'><a href='MySapceReservations.php?id=$rowId' class='text-light'>Reservations</a></button>

              </td>";
    } else {
        echo "<td>
                <button class='btn btn-primary'><a href='MySapceReservations.php?id=$rowId' class='text-light'>Reservations</a></button>
                  <button class='btn btn-primary'><a href='Updateworkspace.php?id=$rowId' class='text-light'>Update</a></button>
                  <button class='btn btn-danger'><a href='Delete.php?delete=$rowId' class='text-light'>Delete</a></button>
              </td>";
    }
    
    echo "</tr>";
    
          
    }}
    ?>
  </tbody>
</table>

</div>

<footer><p>©20241W74</p></footer>

</body>
</html>