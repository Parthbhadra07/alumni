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

// Initialize search variables
$name_filter = "";
$stream_filter = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Sanitize input
    $name_filter = isset($_GET['name']) ? $_GET['name'] : '';
    $stream_filter = isset($_GET['stream']) ? $_GET['stream'] : '';
}

// SQL query to fetch approved users with optional filters
$sql = "SELECT * FROM approved_registrations WHERE 1";

// Add filtering conditions based on the search criteria
if (!empty($name_filter)) {
    $sql .= " AND username LIKE '%" . $conn->real_escape_string($name_filter) . "%'";
}
if (!empty($stream_filter)) {
    $sql .= " AND stream LIKE '%" . $conn->real_escape_string($stream_filter) . "%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Registrations</title>
    <style>
        /* Container that holds all cards */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 16px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 100%;
            width: 300px; /* Default card width */
            display: inline-block;
            vertical-align: top;
            overflow: hidden; /* Ensures the image doesn't overflow the card */
        }

        .card img {
            width: 100%; /* Make the image width fit the card width */
            height: 300px; /* Fixed height for images */
            object-fit: cover; /* Ensure the image covers the area while maintaining aspect ratio */
            border-radius: 4px; /* Optional: For rounded corners */
        }

        .card-title {
            font-size: 1.5em;
            margin: 0;
        }

        .card-body {
            margin-top: 8px;
        }

        /* Filter form styling */
        .filter-form {
            margin: 20px;
            text-align: center;
        }

        .filter-form input[type="text"], .filter-form select {
            padding: 8px;
            margin: 8px;
            font-size: 16px;
        }

        .filter-form button {
            padding: 8px 16px;
            font-size: 16px;
            background-color:#310aa6;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .card {
                width: 250px; /* Adjust card width for medium screens */
            }
        }

        @media (max-width: 992px) {
            .card {
                width: 200px; /* Adjust card width for small screens */
            }
        }

        @media (max-width: 768px) {
            .card {
                width: 100%; /* Make card full width on smaller screens */
                margin: 8px 0; /* Adjust margin for better spacing on small screens */
            }

            .card img {
                height: auto; /* Allow image height to adjust automatically */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'navbar.php'; ?>

        <!-- Filter Form -->
        <div class="filter-form">
            <form method="GET" action="">
                <input type="text" name="name" placeholder="Search by name" value="<?php echo htmlspecialchars($name_filter); ?>">
                <input type="text" name="stream" placeholder="Search by department" value="<?php echo htmlspecialchars($stream_filter); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="cards-container">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    if (!empty($row['photo'])) {
                        echo '<img src="' . htmlspecialchars($row['photo']) . '" alt="Profile Image">';
                    }
                    echo '<h2 class="card-title">' . htmlspecialchars($row['username']) . '</h2>';
                    echo '<div class="card-body">';
                    echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
                    echo '<p>Stream: ' . htmlspecialchars($row['stream']) . '</p>';
                    echo '<p>Year: ' . htmlspecialchars($row['year']) . '</p>';
                    echo '<p>Gender: ' . htmlspecialchars($row['gender']) . '</p>';
                    echo '<p>Current Work: ' . htmlspecialchars($row['current_work']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No approved registrations found.';
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
