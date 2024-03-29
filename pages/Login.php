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
  <header>
  <?php
  session_start();
  if (isset($_SESSION['authenticated'])) {
      unset($_SESSION['authenticated']); // remove the authenticated session variable
  }
  ?>
  </header>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
      <div class="container-fluid bg-body">
        <h1 class="logo">WorkHouse</h1>
        <button
          class="navbar-toggler p-3"
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
              <a
                class="nav-link active p-3"
                aria-current="page"
                href="/workshop/Index.html"
                >Our mission</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link p-3" href="mailto:SystemManager@WorkHouse.com"
                >Contact Us</a
              >
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
          <form method="post" action="helpers/LoginHelper.php" class="form needs-validation" novalidate >
            <p class="title">Sign in</p>
            <p class="message">Sign in to your account .</p>
            <label>
              <input
                class="input"
                type="text"
                placeholder=""
                required=""
                name="userName"
              />
              <span>User Name</span>
            </label>

            <label>
              <input class="input" type="password" placeholder="" name="pass" required="" />
              <span>Password</span>
            </label>
            <button type="submit" class="submit" name="submit">Sign in
            </button>
            <p class="signup-link">
              No account?
              <a href="Register.html">Sign up</a>
            </p>
          </form>
        </div>
      </div>
    </main>
    <footer><p>©20241W74</p></footer>
    <script>
      (function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll(".needs-validation");
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
          form.addEventListener(
            "submit",
            function (event) {
              if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add("was-validated");
            },
            false
          );
        });
      })();
    </script>
    <script src="/workshop/JS/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-GLhlTQ8iKt6iOpSkjE+LBgEFs7otFJbDRlwHzzl5u"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
