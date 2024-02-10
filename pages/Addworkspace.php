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
      $userName = $_SESSION['userName'];
  ?>
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
              <ul class="dropdown-menu dropdown-menu-dark">
                <li>
                  <a class="dropdown-item" href="#">Create new workspace</a>
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
    <div class="container-fluid align-items-center d-flex justify-content-center">
        <div class="row">
            <form class="form" method="post"  action="helpers/AddworkspaceHelper.php" enctype="multipart/form-data">
                <p class="title">Add New Workspace</p>
                <label>
                <select class="input" id="region" name="region" required>
                    <option selected disabled></option>
                    <option value="Center">Center</option>
                    <option option value="North">North</option>
                    <option value="South">South</option>
                    </select>
                    <span>Region</span>
                </label>
                <label>
                    <input class="input" type="text" id="city" name="city" oninput="validateCity(this) " required>
                    <span>City</span>
                </label>
                


                <label>
                    <input class="input" type="text" id="address" name="address" oninput="validateAddress(this)" required>
                    <span>Address</span>
                </label>
                

                <label>
                <select class="input" id="placeType" name="placeType" required>
                    <option selected disabled></option>
                    <option value="office">Office</option>
                    <option option value="hangar">Hangar</option>
                    <option value="workStation">Work Station</option>
                    </select>
                    <span>Workspace type</span>
                </label>

                <label> 
                    <input class="input" type="number" id="dailyPrice" name="dailyPrice" min="0" required>
                    <span>Price per day</span>
                </label>


                <label> 
                <input class="input" type="text" id="ownerName" name="ownerName" oninput="validateFullName(this) " required>
                <span>Owner</span>
                </label>
                
                <label>
                <input
                    class="input"
                    type="email"
                    placeholder=""
                    required=""
                    id="email"
                    name="email"
                    oninput="validateEmail(this)"
                    >
                <span>Email</span>
                </label>
                  

                <label>
                    <input class="input" type="file" id="pictures" name="pictures" accept="image/*" required>
                    <span>Add photos</span>
                </label>
        

                <label> 
                <textarea class="input" id="aboutWorkspace" name="aboutWorkspace" rows="4"></textarea>
                <span>About the Workspace</span>
                </label>

                <button class="submit" type="submit" name="submit">Add workspace</button>
            </form>
        </div>
    </div>

    <footer><p>©20241W74</p></footer>
    <script src="/workshop/JS/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-GLhlTQ8iKt6iOpSkjE+LBgEFs7otFJbDRlwHzzl5u"
    crossorigin="anonymous"
  ></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
   <script>
        // Pattern for only letters and spaces, followed by only numbers
        function validateAddress(input) {
            var pattern = /^[a-zA-Z\s]+ \d{1,3}$/;

            if (!pattern.test(input.value)) {
                input.setCustomValidity(
                "Please enter a valid address (letters and spaces, followed by 1 to 3 numbers)"
                );
            } else {
                input.setCustomValidity("");
            }
            }
            // validate the full name of the user
        function validateFullName(input) {
          var pattern = /^[a-zA-Z]+ [a-zA-Z]+( [a-zA-Z]+)*$/;
          if (!pattern.test(input.value)) {
            input.setCustomValidity("Please enter a valid full name in english");
          } else {
            input.setCustomValidity("");
          }
        }
        function validateCity(input) {
  var pattern = /^[a-zA-Z]+(?: [a-zA-Z]+)*$/;

  if (!pattern.test(input.value)) {
    input.setCustomValidity("Please enter a valid full name with only letters and spaces");
  } else {
    input.setCustomValidity("");
  }
}
    </script>
  </body>

</html>
