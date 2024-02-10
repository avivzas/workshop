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
    <?php
    session_start();
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header('Location: http://localhost/workshop/pages/Login.php');
        exit;
    } else {
        echo "<script>
        window.onload = function() {
            var usernameDiv = document.getElementById('greeting');
            usernameDiv.innerHTML =  'Hello, " . $_SESSION['firstName'] . "';
            }
        </script>";
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
      <div class="container-fluid bg-body  ">
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
    <div class="d-flex justify-content-center align-items-center">
      <img
        src="/workshop/pics/Logo.png"
        class="img-fluid rounded-3 mx-auto"
        alt="LOGO"
        width="200px"
      />
    </div>
    <div><h1 class="greeting m-0 " id="greeting" ></h1></div>
    <div class="d-flex justify-content-center align-items-center m-0 p-2">
    <div id="carouselExample" class="carousel slide" style="max-width: 600px;" data-bs-ride="carousel">
  <div class="carousel-inner  " >
    <div class="carousel-item active" >
      <img src="/workshop/pics/space1.jpg" class="d-block w-100" alt="space 1" >
    </div>
    <div class="carousel-item">
      <img src="/workshop/pics/space2.jpg" class="d-block w-100" alt="space 2">
    </div>
    <div class="carousel-item">
      <img src="/workshop/pics/space3.jpg" class="d-block w-100" alt="space 3">
    </div>
    <div class="carousel-item">
      <img src="/workshop/pics/space4.webp" class="d-block w-100" alt="space 4">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    </div>
    <div class="d-flex justify-content-center align-items-center m-0  p-0">
    <h1 class="greeting">Meet our developers</h1></div>
    <div class="d-flex justify-content-center  m-0  p-0">
      <div class="card m-3 border-black border-2 rounded-2 " style="width: 18rem;">
        <img src="/workshop/pics/aviv.jpg" class="card-img-top" alt="aviv">
        <div class="card-body">
        <p class="card-text"><h3 >Aviv shmilovich</h3><br>How i see my workspace? 
        <br>where ever i want! </p>
        </div>
      </div>
      <div class="card m-3 border-black border-2 rounded-2 " style="width: 18rem;">
        <img src="/workshop/pics/tslil.jpeg" class="card-img-top" alt="aviv">
        <div class="card-body">
        <p class="card-text"><h3 >Tslil nagar</h3><br>Looking to rent your extra workspace? 
        <br>we got you covered </p>
        </div>
      </div>
      <div class="card m-3 border-black rounded-2 border-2" style="width: 18rem;">
        <img src="/workshop/pics/liad.jpeg" class="card-img-top" alt="aviv">
        <div class="card-body">
        <p class="card-text  "><h3 >Liad Arami</h3><br>Im done working at coffee houses  
        </p>
        </div>
      </div>
      <div class="card m-3 border-black rounded-2 border-2" style="width: 18rem;">
        <img src="/workshop/pics/mark.jpg" class="card-img-top" alt="aviv">
        <div class="card-body">
        <p class="card-text  "><h3 >Mark kravetz</h3><br>Start your journey with us today!</p>
        </div>
      </div>
    </div>
    <footer><p>©20241W74</p></footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-GLhlTQ8iKt6iOpSkjE+LBgEFs7otFJbDRlwHzzl5u"
    crossorigin="anonymous"
  ></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  </body>

</html>
