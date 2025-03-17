<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="sty1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container, .modal-content {
            max-width: 600px;
            width: 100%;
        }

        .input-field {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .input-field i {
            margin-right: 10px;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 9999; /* High z-index to ensure it's on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px; /* Space from the top */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* Center horizontally */
            padding: 20px; /* Padding around content */
            border: 1px solid #888;
            width: 80%; /* Adjusted width */
            max-width: 800px; /* Max width to handle smaller screens */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Optional: Adds a shadow for better appearance */
            position: relative; /* Relative positioning for better control */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
        }

        .preview-container p {
            margin: 5px 0;
        }

        .preview-container img {
            max-width: 100%;
            height: auto;
        }

        .preview-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .preview-container table, th, td {
            border: 1px solid #ddd;
        }

        .preview-container th, td {
            padding: 10px;
            text-align: left;
        }

        .preview-container th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form id="registrationForm" method="POST" enctype="multipart/form-data">
                <h2 class="title">Registration Form</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-bars-staggered"></i>
                    <input type="text" name="stream" placeholder="Stream" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-calendar-days"></i>
                    <input type="date" name="year" required>
                </div>
                <div class="input-field radio-group" style="align-items: center;">
                    <i class="fa-solid fa-venus-mars"></i>
                    <label>
                        <input type="radio" name="gender" value="male" required> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" required> Female
                    </label>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-briefcase"></i>
                    <input type="text" name="current_work" placeholder="Currently working at">
                </div>
                <div class="input-field" style="align-items: center;">
                    <i class="fa-solid fa-photo-film"></i>
                    <input type="file" name="photo" required>
                </div>
                <input type="button" value="Preview" class="btn" onclick="showPreview()">
                <input type="submit" value="Submit" class="btn">
                <a href="home.php">Back to Home Page</a>
            </form>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePreview()">&times;</span>
            <h2>Preview</h2>
            <div id="previewContainer" class="preview-container">
                <!-- Preview content will be inserted here -->
            </div>
            <button onclick="confirmSubmission()">Confirm Submission</button>
        </div>
    </div>

    <script>
        function showPreview() {
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = '';

            previewContainer.innerHTML += `<p><strong>Username:</strong> ${formData.get('username')}</p>`;
            previewContainer.innerHTML += `<p><strong>Email:</strong> ${formData.get('email')}</p>`;
            previewContainer.innerHTML += `<p><strong>Stream:</strong> ${formData.get('stream')}</p>`;
            previewContainer.innerHTML += `<p><strong>Year:</strong> ${formData.get('year')}</p>`;
            previewContainer.innerHTML += `<p><strong>Gender:</strong> ${formData.get('gender')}</p>`;
            previewContainer.innerHTML += `<p><strong>Current Work:</strong> ${formData.get('current_work')}</p>`;

            const photoInput = form.querySelector('input[name="photo"]');
            if (photoInput.files[0]) {
                const file = photoInput.files[0];
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer.innerHTML += `<img src="${e.target.result}" alt="Photo Preview">`;
                };
                reader.readAsDataURL(file);
            }

            document.getElementById('previewModal').style.display = 'block';
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
        }

        function confirmSubmission() {
            document.getElementById('previewModal').style.display = 'none';
            document.getElementById('registrationForm').submit();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === document.getElementById('previewModal')) {
                closePreview();
            }
        }
    </script>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</body>
</html> -->







<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action'])) {
    $id = $_POST['id'];
    $action = $_POST['form_action'];

    if ($action == 'approve') {
        // Fetch submission
        $stmt = $conn->prepare("SELECT * FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        // Insert into approved registrations
        $stmt = $conn->prepare("INSERT INTO approved_registrations (username, email, stream, year, gender, current_work, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss', $data['username'], $data['email'], $data['stream'], $data['year'], $data['gender'], $data['current_work'], $data['photo']);
        $stmt->execute();
        $stmt->close();

        // Delete from unapproved submissions
        $stmt = $conn->prepare("DELETE FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $message = "Submission approved and moved to approved registrations.";
    } elseif ($action == 'reject') {
        // Delete from unapproved submissions
        $stmt = $conn->prepare("DELETE FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $message = "Submission rejected.";
    }
}

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="sty1.css">
</head>
<body>
<?php include 'navbar.php'; ?>
    <h1>Admin Panel</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Stream</th>
                <th>Year</th>
                <th>Gender</th>
                <th>Current Work</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
            // mysqli_
            // $conn->open();
            $result = $conn->query("SELECT * FROM unapproved_submissions");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['stream'] . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['current_work'] . "</td>";
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['photo']) . "' width='50' height='50'/></td>";
                echo "<td>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='hidden' name='form_action' value='approve'>
                            <input type='submit' value='Approve'>
                        </form>
                        <form action='' method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='hidden' name='form_action' value='reject'>
                            <input type='submit' value='Reject'>
                        </form>
                      </td>";
                echo "</tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>



























<?php
// Database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'user_auth';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action']) && $_POST['form_action'] == 'submit') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stream = $_POST['stream'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];
    $current_work = $_POST['current_work'];

    // Handle file upload
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = basename($_FILES['photo']['name']);
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . $file_name;

        // Ensure the upload directory exists and is writable
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            $photo = $file_path; // Store the file path in the database
        } else {
            $message = "File upload failed.";
        }
    } else {
        $message = "No file uploaded or file upload error.";
    }

    if ($photo) {
        // Insert into unapproved submissions
        $stmt = $conn->prepare("INSERT INTO unapproved_submissions (username, email, stream, year, gender, current_work, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss', $username, $email, $stream, $year, $gender, $current_work, $photo);

        if ($stmt->execute()) {
            $message = "Submission sent for approval.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="sty1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 9999; /* High z-index to ensure it's on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 20px; /* Space from the top */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 0 auto; /* Center horizontally */
            padding: 15px; /* Padding around content */
            border: 1px solid #888;
            width: 50%; /* Adjusted width */
            max-width: 400px; /* Max width to handle smaller screens */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Optional: Adds a shadow for better appearance */
            position: relative; /* Relative positioning for better control */
            top: 20px; /* Distance from the top */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px; /* Reduced font size */
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" enctype="multipart/form-data" class="sign-in-form">
                    <h2 class="title">Registration Form</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-bars-staggered"></i>
                        <input type="text" name="stream" placeholder="Stream" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="date" name="year" placeholder="Year" required>
                    </div>
                    <div class="input-field radio-group" style="align-items: center;">
                        <i class="fa-solid fa-venus-mars"></i>
                        <label>
                            <input type="radio" name="gender" value="male" required> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" required> Female
                        </label>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-briefcase"></i>
                        <input type="text" name="current_work" placeholder="Currently working at">
                    </div>
                    <div class="input-field" style="align-items: center;">
                        <i class="fa-solid fa-photo-film"></i>
                        <input type="file" name="photo" placeholder="Upload photo" required>
                    </div>
                    
                    <input type="hidden" name="form_action" value="submit">
                    <input type="submit" value="Submit" class="btn solid">
                    <a href="home.php">Back to Home Page</a>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Welcome to the R.K.Desai groups of colleges</h3>
                    <p>
                        We welcome you to the R.K Desail Family,
                        Please fill your details in the form.
                    </p>
                </div>
                <img src="img/04.png" class="image" alt="">
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"><?php echo isset($message) ? $message : ''; ?></p>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Get the message element
        var modalMessage = document.getElementById("modalMessage");

        // Display the modal with a message
        function showModal(message) {
            modalMessage.textContent = message;
            modal.style.display = "block";

            // Automatically hide the modal after 10 seconds
            setTimeout(function() {
                modal.style.display = "none";
            }, 10000); // 10000 milliseconds = 10 seconds
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Check if there's a PHP message and show it
        <?php if (isset($message) && $message) echo "showModal('$message');"; ?>
    </script>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</body>
</html>
