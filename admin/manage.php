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

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM approved_registrations WHERE id = $delete_id";
    if ($conn->query($delete_query) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle edit form submission
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stream = $_POST['stream'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];
    $current_work = $_POST['current_work'];
    
    // Handle file upload for photo (if provided)
    $photo = $_POST['existing_photo']; // Keep existing photo by default
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded file
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
            $photo = $file_path; // Update the photo path in the database
        } else {
            echo "Error uploading file.";
        }
    }

    // Update the record with or without a new photo
    $update_query = "UPDATE approved_registrations SET 
                     username = '$username', 
                     email = '$email', 
                     stream = '$stream', 
                     year = '$year', 
                     gender = '$gender', 
                     current_work = '$current_work', 
                     photo = '$photo'
                     WHERE id = $id";

    if ($conn->query($update_query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch all alumni records
$result = $conn->query("SELECT * FROM approved_registrations");

?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Management</title>
    <link rel="stylesheet" href="sty1.css">
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 5px 10px;
            margin: 5px;
        }
        img {
            width: 50px; /* Display the photo in a small size */
            height: 50px;
            border-radius: 50%; /* Optional: to make it round */
        }
    </style>
</head>
<body style="background-color: #87CEEB;">
    <center><h1>Alumni Management Panel</h1></center>

    <!-- Link to generate report page -->
    <center><a href="generate_report.php"><button>Generate Report</button></a></center>

    <center>
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
                    <th>Photo</th> <!-- Column for photo -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Fetch and display alumni records
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['stream'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['current_work'] . "</td>";
                    // Display photo only if exists
                    echo "<td><img src='" . ($row['photo'] ? $row['photo'] : '') . "' alt='Profile Picture'></td>";
                    echo "<td>
                            <a href='#' onclick='editRecord(" . $row['id'] . ", \"" . $row['username'] . "\", \"" . $row['email'] . "\", \"" . $row['stream'] . "\", " . $row['year'] . ", \"" . $row['gender'] . "\", \"" . $row['current_work'] . "\", \"" . $row['photo'] . "\")'><button>Edit</button></a>
                            <a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'><button>Delete</button></a>
                          </td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </center>

    <!-- Edit form (hidden initially) -->
    <div id="editForm" style="display:none; text-align:center; background-color:#f4f4f4; padding:20px; border:1px solid #ddd; width: 50%; margin:auto;">
        <h2>Edit Alumni Record</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_id" name="id">
            <label for="username">Username:</label><br>
            <input type="text" id="edit_username" name="username" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="edit_email" name="email" required><br><br>

            <label for="stream">Stream:</label><br>
            <input type="text" id="edit_stream" name="stream" required><br><br>

            <label for="year">Year:</label><br>
            <input type="date" id="edit_year" name="year" required><br><br>

            <label for="gender">Gender:</label><br>
            <input type="text" id="edit_gender" name="gender" required><br><br>

            <label for="current_work">Current Work:</label><br>
            <input type="text" id="edit_current_work" name="current_work" required><br><br>

            <label for="photo">Photo (optional):</label><br>
            <input type="file" id="edit_photo" name="photo"><br><br>
            <input type="hidden" id="existing_photo" name="existing_photo"> <!-- Hidden field for existing photo path -->

            <button type="submit" name="update">Save Changes</button>
            <button type="button" onclick="document.getElementById('editForm').style.display='none'">Cancel</button>
        </form>
    </div>

    <script>
        function editRecord(id, username, email, stream, year, gender, current_work, photo) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_stream').value = stream;
            document.getElementById('edit_year').value = year;
            document.getElementById('edit_gender').value = gender;
            document.getElementById('edit_current_work').value = current_work;
            document.getElementById('existing_photo').value = photo;
        }
    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
