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

$user = $_SESSION['userName'];
$sql = "SELECT * FROM `registrations` WHERE userName='$user' limit 1";
$result = $conn->query($sql);
if(!$result){
    die( $conn->connect_error);
}
$row = $result->fetch_assoc();
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
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>

    <link rel="icon" href="/workshop/pics/Logo.png" />
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
      <div class="container-fluid bg-body">
        <h1 class="logo">WorkHouse</h1>
        <button
          class="navbar-toggler"
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
                  <a class="dropdown-item" href="#">Exists Reservations</a>
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
                <a class="dropdown-item" href="#">Edit profile</a>
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
    <div class="d-flex justify-content-center align-items-center">
      <img
        src="/workshop/pics/Logo.png"
        class="img-fluid rounded-3 mx-auto"
        alt="LOGO"
        width="200px"
      />
    </div>
    <main>
      <div
        class="container-fluid align-items-center d-flex justify-content-center"
      >
        <div class="row">
          <form
            method="post"
            action="helpers/EditprofileHelper.php"
            class="form needs-validation"
          >
            <p class="title">Update profile</p>
            <div class="flex">
              <label>
                <input
                  class="input"
                  type="text"
                  placeholder=""
                  required=""
                  id="firstName"
                  name="firstName"
                  value="<?= $row['firstName'];?>"
                  oninput="validateName(this)"
                />
                <span>First name</span>
              </label>

              <label>
                <input
                  class="input"
                  type="text"
                  placeholder=""
                  required=""
                  id="lastName"
                  name="lastName"
                  value="<?= $row['lastName'];?>"
                  oninput="validateName(this)"
                />
                <span>Last name</span>
              </label>
            </div>
            <label>
              <input
                class="input"
                type="password"
                id="pass"
                name="pass"
                placeholder=""
                
              />
              <span>New Password</span>
            </label>
            <label>
              <input
                class="input"
                type="password"
                id="confirmPass"
                placeholder=""
                
              />
              <span>Confirm new password</span>
            </label>

            <label>
              <input
                class="input"
                type="text"
                placeholder=""
                required=""
                id="userName"
                value="<?= $row['userName'];?>"
                disabled
                oninput="validateName(this) "

              />
              <span>User Name</span>
            </label>

            <label>
              <input
                class="input"
                type="email"
                placeholder=""
                required=""
                id="email"
                value="<?= $row['email'];?>"
                disabled
                oninput="validateEmail(this)"
              />
              <span>Email</span>
            </label>

            <button class="submit" type="submit" name="submit">Update</button>
          </form>
        </div>
      </div>
    </main>
    <footer><p>©20241W74</p></footer>
    <script src="/workshop/JS/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-GLhlTQ8iKt6iOpSkjE+LBgEFs7otFJbDRlwHzzl5u"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

