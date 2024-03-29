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
    
    <script src="https://www.paypal.com/sdk/js?client-id=AYfx2ygnKxYNcFXhf8ScEFk899qs9GAlHajx28L98g62sok1GvI716Qb9sNvKummn8MlTJ3ZS_hnl3be&currency=ILS"></script>

    
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
                  <a class="dropdown-item" href="SearchWorkspace.php">Search new workspace</a>
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
    <h1 class="greeting">Check Out</h1></div>
    <button class="btn btn-danger my-5 mx-5 px-5 py-2 "> <a href="SearchWorkspace.php" class="text-light"> Cancel </a></button>
<table class="table m-0 p-0">
  <thead>
    <tr>
    <th scope="col">Region</th>
      <th scope="col">City</th>
      <th scope="col">Address</th>
      <th scope="col">Place Type</th>
      <th scope="col">Daily price</th>
      <th scope="col">Owner name</th>
      <th scope="col">Picture</th>
      <th scope="col">About</th>
      <th scope="col">Total Price</th>
      <th scope="col">Options</th>
    </tr>


  </thead> 

  <tbody>
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
$user = $_SESSION['userName'];
if (isset($_POST['submit'])) {
    $workspaceID = $_POST['workspaceID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $region = $_POST['region'];
    $city = $_POST['city'];
    $ownerName = $_POST['ownerName'];
    $address = $_POST['address'];
    $placeType = $_POST['placeType'];
    $dailyPrice = $_POST['dailyPrice'];
    $imageSrc = $_POST['imageSrc'];
    $total = $_POST['total'];
    $aboutWorkspace = $_POST['aboutWorkspace'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
}
// Convert start and end dates to DateTime objects
$startDateObj = new DateTime($startDate);
$endDateObj = new DateTime($endDate);

// Calculate the difference between the dates
$interval = $startDateObj->diff($endDateObj);

// Convert date interval to total days
$days = (int)$interval->format('%a');
$total = $dailyPrice * ($days);

echo "<tr>
<th scope='row'> $region </th>
<td>$city</td>
<td>$address</td>
<td>$placeType</td>
<td>$dailyPrice</td>
<td>$ownerName</td>
<td><img src='$imageSrc' alt='Workspace Image' width='200' height='200'></td>
<td>$aboutWorkspace</td>
<td>$total</td>
<td>
<div id='paypal-button-container'></div>
</td>
</tr>";
 ?>
  </tbody>
</table>

</div>

<footer><p>©20241W74</p></footer>

<script>
  paypal.Buttons({
    createOrder: function(data, actions) { 
      // Set up the transaction
      return actions.order.create({
        purchase_units: [{
          amount: {
            currency_code: "ILS",
            value: '<?php echo $total; ?>' 
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // Capture the funds from the transaction
      return actions.order.capture().then(function(details) {
        // Show a success message to your buyer
        alert('Transaction completed by ' + details.payer.name.given_name);
        
        $.ajax({
          url: 'http://localhost/workshop/pages/helpers/ReserveHelper.php',
          method: 'POST',
          data: {
            workspaceID: '<?php echo $workspaceID; ?>', 
            startDate: '<?php echo $startDate; ?>',
            endDate: '<?php echo $endDate; ?>',
            email: '<?php echo $email; ?>',
            userName: '<?php echo $_SESSION['userName']; ?>',
            fullName: '<?php echo $fullName; ?>' 
          },
          success: function(response) {
            window.location.href = 'ExistReservations.php';
          },
          error: function(xhr, status, error) {
            // Enhanced error logging
            console.error("AJAX Error:", status, error, xhr.responseText);
          }
        });
      });
    },
    onError: function (err) {
      // Debug: Log any errors encountered during the transaction
      console.error("PayPal Button Error:", err);
    }
  }).render('#paypal-button-container');

</script>

</body>

</html>