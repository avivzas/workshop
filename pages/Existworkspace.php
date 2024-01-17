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
    // Replace these placeholders with your actual database connection details
    $servername = "localhost";
    $username = "test";
    $password = "12345";
    $dbname = "sadna";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get property details from the database
    $propertyId = $_GET['propertyId']; // assuming you pass the property ID via URL
    $sql = "SELECT * FROM properties WHERE id = $propertyId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Property not found.";
        exit;
    }

    // Get property photos from the database
    $photoSql = "SELECT * FROM property_photos WHERE property_id = $propertyId";
    $photoResult = $conn->query($photoSql);

    $photoData = array();
    if ($photoResult->num_rows > 0) {
        while ($photoRow = $photoResult->fetch_assoc()) {
            $photoData[] = $photoRow['photo_path'];
        }
    }

    // Close the database connection
    $conn->close();
    ?>
    

    <h1 style="margin: auto; color: blue;">Update Property</h1>

    <form action="process_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="propertyId" value="<?php echo $row['id']; ?>">

        <label>
            <input class="input blocked" type="text" id="city" name="city" value="<?php echo $row['city']; ?>" oninput="validateName(this)" required readonly>
            <span>City</span>
        </label>

        <label>
            <input class="input blocked" type="text" id="address" name="address" value="<?php echo $row['address']; ?>" oninput="validateAddress(this)" required readonly>
            <span>Address</span>
        </label>

        <label>
            <select class="input blocked" id="placeType" name="placeType" required disabled>
                <option value="office" <?php echo ($row['workspace_type'] == 'office') ? 'selected' : ''; ?>>Office</option>
                <option value="hangar" <?php echo ($row['workspace_type'] == 'hangar') ? 'selected' : ''; ?>>Hangar</option>
                <option value="workStation" <?php echo ($row['workspace_type'] == 'workStation') ? 'selected' : ''; ?>>Work Station</option>
            </select>
            <span>Workspace type</span>
        </label>

        <label>
            <select class="input blocked" id="rentalPeriod" name="rentalPeriod" required disabled>
                <option value="someDays" <?php echo ($row['min_reservation'] == 'someDays') ? 'selected' : ''; ?>>Some Days</option>
                <option value="weeks" <?php echo ($row['min_reservation'] == 'weeks') ? 'selected' : ''; ?>>Weeks</option>
                <option value="months" <?php echo ($row['min_reservation'] == 'months') ? 'selected' : ''; ?>>Months</option>
            </select>
            <span>Minimum reservation time</span>
        </label>

        <label>
            <input class="input blocked" type="number" id="dailyPrice" name="dailyPrice" min="0" value="<?php echo $row['price_per_day']; ?>" required readonly>
            <span>Price per day</span>
        </label>

        <label>
            <input class="input blocked" type="text" id="ownerName" name="ownerName" value="<?php echo $row['owner']; ?>" oninput="validateFullName(this)" required readonly>
            <span>Owner</span>
        </label>

        <label>
            <input class="input blocked" type="email" id="email" name="email" value="<?php echo $row['email']; ?>" oninput="validateEmail(this)" required readonly>
            <span>Email</span>
        </label>

        <label>
            <input class="input blocked" type="file" id="pictures" name="pictures" accept="image/*" multiple disabled>
            <span>Add photos</span>
            <button type="button" onclick="seeAllPhotos()">See All Photos</button>
            <button type="button" onclick="deleteAllPhotos()">Delete All Photos</button>
        </label>

        <label>
            <textarea class="input blocked" id="aboutWorkspace" name="aboutWorkspace" rows="4" readonly><?php echo $row['about_workspace']; ?></textarea>
            <span>About the Workspace</span>
        </label>

        <button class="submit" type="button" onclick="enableEditing()">Edit</button>
        <button class="submit" type="submit" name="submit" disabled>Update workspace</button>

        <!-- Photo container for displaying all photos -->
        <div class="photo-container" id="photoContainer" style="display: none;">
            <?php foreach ($photoData as $photoPath) : ?>
                <div class="property-photo">
                    <img src="<?php echo $photoPath; ?>" alt="Property Photo">
                    <button type="button" class="delete-button" onclick="deletePhoto('<?php echo $photoPath; ?>')">Delete</button>
                </div>
            <?php endforeach; ?>
        </div>
    </form>

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

        // Validate the full name of the user
        function validateFullName(input) {
            var pattern = /^[a-zA-Z]+ [a-zA-Z]+( [a-zA-Z]+)*$/;
            if (!pattern.test(input.value)) {
                input.setCustomValidity("Please enter a valid full name in English");
            } else {
                input.setCustomValidity("");
            }
        }

        // Function to enable editing
        function enableEditing() {
            var inputs = document.getElementsByClassName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].removeAttribute("readonly");
                inputs[i].classList.remove("blocked");
            }

            document.getElementById("rentalPeriod").removeAttribute("disabled");
            document.getElementById("placeType").removeAttribute("disabled");
            document.getElementById("pictures").removeAttribute("disabled");

            // Enable the update button
            document.querySelector("button[name='submit']").removeAttribute("disabled");
        }

        // Function to see all photos
        function seeAllPhotos() {
            var photoContainer = document.getElementById("photoContainer");
            photoContainer.style.display = "flex";
        }

        // Function to delete all photos
        function deleteAllPhotos() {
            var confirmation = confirm("Are you sure you want to delete all photos?");
            if (confirmation) {
                // Add your code here to delete all photos from the database
                alert("All photos deleted successfully!");
                // Remove all photos from the UI
                var photoContainer = document.getElementById("photoContainer");
                photoContainer.innerHTML = '';
            }
        }

        // Function to delete a photo
        function deletePhoto(photoPath) {
            var confirmation = confirm("Are you sure you want to delete this photo?");
            if (confirmation) {
                // Add your code here to delete the photo from the database
                alert("Photo deleted successfully!");
                // Remove the deleted photo from the UI
                var photoElement = event.target.parentNode;
                photoElement.parentNode.removeChild(photoElement);
            }
        }
    </script>

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