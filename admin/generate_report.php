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

// Handle report generation
if (isset($_GET['generate_pdf'])) {
    // Get the selected stream and orientation from the URL parameters
    $stream = isset($_GET['stream']) ? $_GET['stream'] : '';
    $orientation = isset($_GET['orientation']) ? $_GET['orientation'] : 'P';
    
    // Fetch alumni records based on the selected stream
    $query = "SELECT * FROM approved_registrations";
    if ($stream != '') {
        $query .= " WHERE stream LIKE ?";
    }
    $stmt = $conn->prepare($query);
    
    if ($stream != '') {
        $stream_param = "%" . $stream . "%"; // To search for streams containing the text
        $stmt->bind_param("s", $stream_param);  // Bind the stream parameter
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Generate PDF with selected orientation and filtered results
    generate_pdf($result, $orientation);
}

// Function to generate PDF report
function generate_pdf($result, $orientation) {
    require('C:/xampp/htdocs/Parth/topsecrete/admin/pdf/fpdf.php');  // Include the FPDF library

    // Create a new PDF document with the selected orientation
    $pdf = new FPDF($orientation, 'mm', 'A4'); // 'P' for portrait, 'L' for landscape
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Add a header
    $pdf->Cell(0, 10, 'Alumni Report', 0, 1, 'C');

    // Add table headers
    $pdf->Cell(30, 10, 'ID', 1);
    $pdf->Cell(40, 10, 'Username', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(40, 10, 'Stream', 1);
    $pdf->Cell(30, 10, 'Year', 1);
    $pdf->Cell(30, 10, 'Gender', 1);
    $pdf->Cell(50, 10, 'Current Work', 1);
    $pdf->Ln();

    // Add data rows
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['id'], 1);
        $pdf->Cell(40, 10, $row['username'], 1);
        $pdf->Cell(60, 10, $row['email'], 1);
        $pdf->Cell(40, 10, $row['stream'], 1);
        $pdf->Cell(30, 10, $row['year'], 1);
        $pdf->Cell(30, 10, $row['gender'], 1);
        $pdf->Cell(50, 10, $row['current_work'], 1);
        $pdf->Ln();
    }

    // Output the PDF
    $pdf->Output('D', 'alumni_report.pdf');
    exit();
}
?>

<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Alumni Report</title>
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
        .button-container {
            margin: 20px auto;
            text-align: center;
        }
        /* Align the form elements horizontally */
        .form-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }
        .form-row label {
            margin-right: 10px;
        }
        .form-row input[type="text"] {
            padding: 5px;
            width: 200px;
        }
        .form-row input[type="radio"] {
            margin-left: 10px;
        }
    </style>
</head>
<body style="background-color: #87CEEB;">
    <center><h1>Preview Alumni Report</h1></center>

    <!-- Form to select PDF orientation and stream filter - Placed above the table -->
    <div class="button-container">
        <form action="" method="get">
            <div class="form-row">
                <div>
                    <label for="orientation">Select Orientation:</label><br>
                    <input type="radio" id="portrait" name="orientation" value="P" checked>
                    <label for="portrait">Portrait</label>
                    <input type="radio" id="landscape" name="orientation" value="L">
                    <label for="landscape">Landscape</label>
                </div>

                <div>
                    <!-- Text box to input stream filter -->
                    <label for="stream">Enter Stream:</label><br>
                    <input type="text" name="stream" id="stream" placeholder="Enter stream (e.g.,BCA , MCA)"><br><br>
                </div>
                
                <div>
                    <button type="submit" name="generate_pdf" value="1">Generate PDF Report</button>
                </div>
            </div>
        </form>
    </div>

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
                </tr>
            </thead>
            <tbody>
            <?php
                // Fetch all alumni records
                $result = $conn->query("SELECT * FROM approved_registrations");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['stream'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['current_work'] . "</td>";

                    $photo = $row['photo'];
                    if ($photo) {
                        $base64_image = base64_encode($photo);
                    echo "<td><img src='" . ($row['photo'] ? $row['photo'] : '') . "' alt='Profile Picture'></td>";
                    } else {
                        echo "<td>No photo available</td>";
                    }
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </center>
</body>
</html>

<?php
$conn->close();
?>
