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
    die("You must be logged in to update the form.");
}

// Now you can safely access $_SESSION['username']
$user = $_SESSION['username']; // Assuming username is stored in session after successful login

// Fetch the user_id and other details from the unapproved_submissions table
$query = "SELECT id, username, email, stream, year, gender, current_work, rejection_reason FROM unapproved_submissions WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->bind_result($user_id, $username, $email, $stream, $year, $gender, $current_work, $rejection_reason);
$stmt->fetch();
$stmt->close();

// If user_id is not found or if the form was not rejected, show a message and stop further processing
if (!$user_id || empty($rejection_reason)) {
    $message = "Your form has either been approved or not yet rejected. Please contact the administrator for further assistance.";
    $show_form = false;  // Do not show the form if the form is not rejected
} else {
    $show_form = true;  // Show the form if the form is rejected
}

// Handle form submission for updating user data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action']) && $_POST['form_action'] == 'update') {
    // Get the updated data from the form
    $updated_username = $_POST['username'];
    $updated_email = $_POST['email'];
    $updated_stream = $_POST['stream'];
    $updated_year = $_POST['year'];
    $updated_gender = $_POST['gender'];
    $updated_current_work = $_POST['current_work'];

    // Set rejection_reason to blank (empty string)
    $rejection_reason = '';  // Set rejection_reason to blank (empty string)

    // Handle file upload for profile picture (optional)
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
        }
    } else {
        $photoError = "You must upload a photo.";
    }

    // If there is no error, proceed with the update
    if (!isset($photoError)) {
        // Update user details in the database
        $update_query = "UPDATE unapproved_submissions SET username = ?, email = ?, stream = ?, year = ?, gender = ?, current_work = ?, photo = ?, rejection_reason = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);

        // Bind the parameters, including rejection_reason (which is set to '')
        $stmt->bind_param('ssssssssi', $updated_username, $updated_email, $updated_stream, $updated_year, $updated_gender, $updated_current_work, $photo, $rejection_reason, $user_id);

        if ($stmt->execute()) {
            $message = "Your details have been updated successfully.";
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
    <title>Update Registration Form</title>
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
                <?php if ($show_form): ?>
                    <form action="" method="POST" enctype="multipart/form-data" class="sign-in-form">
                        <h2 class="title">Update Your Registration Details</h2>

                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fa-solid fa-bars-staggered"></i>
                            <input type="text" name="stream" value="<?php echo htmlspecialchars($stream); ?>" required>
                        </div>
                        <div class="input-field">
                            <i class="fa-solid fa-calendar-days"></i>
                            <input type="date" name="year" value="<?php echo htmlspecialchars($year); ?>" required>
                        </div>
                        <div class="input-field radio-group" style="align-items: center;">
                            <i class="fa-solid fa-venus-mars"></i>
                            <label>
                                <input type="radio" name="gender" value="male" <?php echo $gender == 'male' ? 'checked' : ''; ?> required> Male
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female" <?php echo $gender == 'female' ? 'checked' : ''; ?> required> Female
                            </label>
                        </div>
                        <div class="input-field">
                            <i class="fa-solid fa-briefcase"></i>
                            <input type="text" name="current_work" value="<?php echo htmlspecialchars($current_work); ?>" placeholder="Currently working at">
                        </div>
                        <div class="input-field" style="align-items: center;">
                            <i class="fa-solid fa-photo-film"></i>
                            <input type="file" name="photo" required>
                        </div>

                        <?php
                        // Display error message if photo is not uploaded
                        if (isset($photoError)) {
                            echo '<div style="color: red; font-size: 14px;">' . $photoError . '</div>';
                        }
                        ?>

                        <input type="hidden" name="form_action" value="update">
                        <input type="submit" value="Update" class="btn solid">
                        <a href="home.php">Back to Home Page</a>
                    </form>
                <?php else: ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
</body>
</html>
