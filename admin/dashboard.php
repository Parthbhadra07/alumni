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

// Initialize $action to prevent undefined variable warning
$action = isset($_POST['form_action']) ? $_POST['form_action'] : '';

// Handle approval or rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action'])) {
    $id = $_POST['id'];
    $action = $_POST['form_action'];

    if ($action == 'approve') {
        // Fetch the unapproved submission
        $stmt = $conn->prepare("SELECT * FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        // Insert into approved registrations
        $stmt = $conn->prepare("INSERT INTO approved_registrations (user_id, username, email, stream, year, gender, current_work, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssssss', $data['user_id'], $data['username'], $data['email'], $data['stream'], $data['year'], $data['gender'], $data['current_work'], $data['photo']);
        $stmt->execute();
        $stmt->close();

        // Delete from unapproved submissions
        $stmt = $conn->prepare("DELETE FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $message = "Submission approved and moved to approved registrations.";
    } elseif ($action == 'reject') {
        // Fetch the unapproved submission
        $stmt = $conn->prepare("SELECT * FROM unapproved_submissions WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        // Update the status to 'rejected' and store the rejection reason
        $rejection_reason = $_POST['rejection_reason'] ?? 'No reason provided';
        $stmt = $conn->prepare("UPDATE unapproved_submissions SET  rejection_reason = ? WHERE id = ?");
        $stmt->bind_param('si', $rejection_reason, $id);
        $stmt->execute();
        $stmt->close();

        $message = "Submission rejected.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>

    <script>
        // JavaScript function to show the rejection prompt
        function rejectSubmission(id) {
            var reason = prompt("Please provide the reason for rejection:");
            if (reason != null && reason != "") {
                // Create a hidden form to submit the rejection reason along with the ID
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                var hiddenIdInput = document.createElement('input');
                hiddenIdInput.type = 'hidden';
                hiddenIdInput.name = 'id';
                hiddenIdInput.value = id;
                form.appendChild(hiddenIdInput);

                var hiddenActionInput = document.createElement('input');
                hiddenActionInput.type = 'hidden';
                hiddenActionInput.name = 'form_action';
                hiddenActionInput.value = 'reject';
                form.appendChild(hiddenActionInput);

                var hiddenReasonInput = document.createElement('input');
                hiddenReasonInput.type = 'hidden';
                hiddenReasonInput.name = 'rejection_reason';
                hiddenReasonInput.value = reason;
                form.appendChild(hiddenReasonInput);

                // Append the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body style="background-color: #87CEEB;">
<?php include 'navbar.php'; ?>
    <center><h1>Admin Panel</h1></center>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

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
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch unapproved submissions where rejection_reason is NULL or empty
                $result = $conn->query("SELECT * FROM unapproved_submissions WHERE (rejection_reason IS NULL OR rejection_reason = '')");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['stream'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['current_work'] . "</td>";

                    // Display photo as base64 if it's stored in the database as a BLOB
                    $photo = $row['photo'];
                    if ($photo) {
                        $base64_image = base64_encode($photo);
                    echo "<td><img src='" . ($row['photo'] ? $row['photo'] : '') . "' alt='Profile Picture'></td>";
                    } else {
                        echo "<td>No photo available</td>";
                    }

                    // Approve form
                    echo "<td>
                            <form action='' method='post' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='hidden' name='form_action' value='approve'>
                                <input type='submit' value='Approve'>
                            </form>
                            <button onclick='rejectSubmission(" . $row['id'] . ")'>Reject</button>
                          </td>";
                    echo "</tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </center>
</body>
</html>
