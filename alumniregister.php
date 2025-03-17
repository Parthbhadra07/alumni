<?php
// Start the session to track logged-in user
session_start();

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

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['username'])) {
    die("You must be logged in to submit the form.");
}

// Now you can safely access $_SESSION['username']
$user = $_SESSION['username']; // Assuming username is stored in session after successful login

// Fetch the user_id from the users table
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

// If user_id is not found, show an error
if (!$user_id) {
    die("User ID not found.");
}

// Check if the user has already submitted the form
$query = "SELECT COUNT(*) FROM approved_registrations WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user); // Use 's' for string type binding
$stmt->execute();
$stmt->bind_result($approved_submission_count);
$stmt->fetch();
$stmt->close();

// Check if the user has unapproved submission
$query = "SELECT COUNT(*) FROM unapproved_submissions WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user); // Use 's' for string type binding
$stmt->execute();
$stmt->bind_result($unapproved_submission_count);
$stmt->fetch();
$stmt->close();

// Fetch rejection reason if any submission is rejected
$query = "SELECT rejection_reason FROM unapproved_submissions WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->bind_result($rejection_reason);
$stmt->fetch();
$stmt->close();

// Message initialization
$message = '';

if ($approved_submission_count > 0) {
    $message = "Your form has already been approved.";
} elseif ($unapproved_submission_count > 0) {
    if (!empty($rejection_reason)) {
        $message = "Your form was rejected. Reason: " . $rejection_reason;
    } else {
        $message = "Your form has been sent for approval.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action']) && $_POST['form_action'] == 'submit') {
    // Check if the user has already submitted the form again after form submission attempt
    if ($approved_submission_count > 0 || $unapproved_submission_count > 0) {
        $message = "You have already submitted the form.";
    } else {
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
            // Insert the form data including the user_id
            $stmt = $conn->prepare("INSERT INTO unapproved_submissions (user_id, username, email, stream, year, gender, current_work, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isssssss', $user_id, $username, $email, $stream, $year, $gender, $current_work, $photo);

            if ($stmt->execute()) {
                $message = "Submission sent for approval.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
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

        // Display the modal with a message
        function showModal(message) {
            modalMessage.textContent = message;
            modal.style.display = "block";

            // Automatically hide the modal after 10 seconds
            setTimeout(function() {
                modal.style.display = "none";
            }, 10000); // 10000 milliseconds = 10 seconds
        }

        // When the user clicks on <span> (x), close the modal and redirect
        span.onclick = function() {
            modal.style.display = "none"; // Hide the modal
            window.location.href = "home.php"; // Redirect to home page
        }

        // When the user clicks anywhere outside of the modal, close it and redirect
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none"; // Hide the modal
                window.location.href = "home.php"; // Redirect to home page
            }
        }

        // Check if there's a PHP message and show it
        <?php if (isset($message) && $message) echo "showModal('$message');"; ?>
        
    </script>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

</body>
</html>
