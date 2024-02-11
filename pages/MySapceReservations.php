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
if (!isset($_GET['id'])) {
    die('missing id');
      
  }
$id = $_GET['id'];

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
                  <a class="dropdown-item" href="Existworkspace.php">Exists workspaces</a>
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

<    <div class="container-fluid p-0 m-0">
        <div class="d-flex justify-content-center align-items-center m-0 pt-5 pb-0">
            <h1 class="greeting">My Workspaces Reservations</h1>
        </div>

        <button class="btn btn-primary my-5 mx-5 px-5 py-2">
            <a href="Existworkspace.php" class="text-light">Back</a>
        </button>

        <!-- Future Reservations Table -->
        <h2>Future Reservations</h2>
        <table class="table m-0 p-0">
            <thead>
                <tr>
                    <th scope="col">Full name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $today = date('Y-m-d');
                $sqlFuture = "SELECT * FROM `reservations` WHERE spaceID=$id AND endDate >= '$today'";
                $resultFuture = $conn->query($sqlFuture);
                if ($resultFuture->num_rows > 0) {
                    while ($row = $resultFuture->fetch_assoc()) {
                        echo "<tr>
                            <th scope='row'>" . htmlspecialchars($row['fullName']) . "</th>
                            <td>" . htmlspecialchars(date('d-m-Y', strtotime($row['startDate']))) . "</td>
                            <td>" . htmlspecialchars(date('d-m-Y', strtotime($row['endDate']))) . "</td>
                            <td>
                                <button class='btn btn-primary'><a href='mailto:" . htmlspecialchars($row['email']) . "' class='text-light'>Contact</a></button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No future reservations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Past Reservations Table -->
        <h2>Past Reservations</h2>
        <table class="table m-0 p-0">
            <thead>
                <tr>
                    <th scope="col">Full name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlPast = "SELECT * FROM `reservations` WHERE spaceID=$id AND endDate < '$today'";
                $resultPast = $conn->query($sqlPast);
                if ($resultPast->num_rows > 0) {
                    while ($row = $resultPast->fetch_assoc()) {
                        echo "<tr>
                            <th scope='row'>" . htmlspecialchars($row['fullName']) . "</th>
                            <td>" . htmlspecialchars(date('d-m-Y', strtotime($row['startDate']))) . "</td>
                            <td>" . htmlspecialchars(date('d-m-Y', strtotime($row['endDate']))) . "</td>
                            <td>
                                <button class='btn btn-primary'><a href='mailto:" . htmlspecialchars($row['email']) . "' class='text-light'>Contact</a></button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No past reservations found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

<footer><p>©20241W74</p></footer>
</body>
</html>