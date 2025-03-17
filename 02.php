<?php
session_start(); // Start the session

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Page</title>
    <style>
        /* Reset default styles */
        body, a {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            color: inherit;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navigation bar styles */
        .navbar {
            background: #010334; /* Primary color */
            color: #fff;
            padding: 0.5em 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar .nav-links {
            display: flex;
            gap: 1em;
        }

        .navbar .nav-links a {
            color: #fff;
            padding: 0.5em 1em;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        .navbar .nav-links a:hover {
            background: #310aa6; /* Darker shade of primary color */
            color: #fff;
        }

        .navbar .nav-links a.active {
            background: #310aa6; /* Darker shade of primary color */
            color: #fff;
        }

        .navbar .contact-info {
            display: flex;
            align-items: center;
            gap: 1em;
        }

        .navbar .contact-info .contact-number {
            font-size: 1em;
        }

        .navbar .contact-info .login-button {
            background: #310aa6; /* Green color for button */
            color: #fff;
            padding: 0.5em 1em;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        .navbar .contact-info .login-button:hover {
            background: #010334; /* Darker shade of green */
        }
        /* CSS styles for dropdown */
        .dropdown {
            position: relative; /* Positioning context for the dropdown menu */
            display: inline-block;
        }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px; /* Minimum width of the dropdown menu */
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1; /* Ensure the dropdown is above other elements */
            border-radius: 4px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1; /* Highlight on hover */
        }

        .dropdown-button {
            cursor: pointer; /* Change cursor to pointer on hover */
            background: #310aa6;
            padding: 0.5em 1em;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }
            
        
        .dropdown-button:hover{
            background: #010334; /* Darker shade of green */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .nav-links {
                flex-direction: column;
                width: 100%;
            }

            .navbar .nav-links a {
                width: 100%;
                text-align: center;
                padding: 1em;
            }

            .navbar .contact-info {
                margin-top: 1em;
                width: 100%;
                justify-content: space-between;
            }
        }
         
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">R.K.Desai groups of college</div>
        <div class="nav-links">
            <a href="home.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'home.php') ? 'active' : ''; ?>">Home</a>
            <a href="about.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">About</a>
            <a href="events.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'events.php') ? 'active' : ''; ?>">Events</a>
            <a href="alumni.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'alumni.php') ? 'active' : ''; ?>">Alumni</a>
            <a href="contact.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">Contact</a>
            <?php if ($isLoggedIn): ?>
                <a href="alumniregister.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'alumniregister.php') ? 'active' : ''; ?>">Alumni-Registration</a>
            <?php else: ?>
              
            <?php endif; ?>


        </div>
        <div class="contact-info">
            <span class="contact-number">Call Us: (123) 456-7890</span>
            <?php if ($isLoggedIn): ?>
                <div class="dropdown">
        <span class="dropdown-button">Welcome, <?php echo htmlspecialchars($username); ?></span>
        <div class="dropdown-content">
            <a href="#">Profile</a>
            <a href="#">Edit Alumni Form</a>
            
        </div>
    </div> 
                <a href="logout.php" class="login-button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-button">Login/Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <script>
        // JavaScript to handle dropdown toggle
        document.addEventListener('DOMContentLoaded', function () {
            var dropdownButton = document.querySelector('.dropdown-button');
            var dropdownContent = document.querySelector('.dropdown-content');

            dropdownButton.addEventListener('click', function () {
                // Toggle the display of the dropdown menu
                if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
                    dropdownContent.style.display = 'block';
                } else {
                    dropdownContent.style.display = 'none';
                }
            });

            // Close the dropdown menu if the user clicks outside of it
            window.addEventListener('click', function (event) {
                if (!event.target.matches('.dropdown-button')) {
                    if (dropdownContent.style.display === 'block') {
                        dropdownContent.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>





































<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require './phpmailer/vendor/autoload.php'; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Validate form data
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'jokxr360@gmail.com'; // Your Gmail address
        $mail->Password = 'falj surw ocqa srqr'; // Use an App Password, not your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Gmail's SMTP port

        // Recipients
        $mail->setFrom('jokxr360@gmail.com', 'RK Desai College');
        $mail->addAddress($email, $name); // Send to the user's email
        $mail->addAddress('jokxr360@gmail.com', 'Admin'); // Admin email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for contacting RK Desai College';
        $mail->Body    = "<p>Dear $name,</p>
                          <p>Thank you for getting in touch with us. Below are the details of your message:</p>
                          <p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Message:</strong></p>
                          <p>$message</p>
                          <p>We will get back to you shortly.</p>";

        // Send the email
        $mail->send();
        echo 'Confirmation email sent to ' . $email;

        // Admin email
        $mail->clearAddresses();
        $mail->addAddress('jokxr360@gmail.com', 'Admin'); // Admin email
        $mail->Subject = "New Contact Us Message from $name";
        $mail->Body    = "<p>You have received a new message from the Contact Us form on your website:</p>
                          <p><strong>Name:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Message:</strong></p>
                          <p>$message</p>";

        $mail->send();
        echo 'Admin has been notified.';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - RK Desai College</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background: #f4f4f4;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }
        h1 {
            color: #333;
        }
        .contact-section {
            padding: 20px 0;
        }
        .contact-details {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .contact-details h2 {
            color: #333;
        }
        .contact-details p {
            margin-bottom: 10px;
        }
        .contact-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .contact-form button {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-form button:hover {
            background: #555;
        }
        .map {
            margin-top: 20px;
        }
        iframe {
            width: 100%;
            border: 0;
            height: 400px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Contact Us - RK Desai College</h1>
    </header>

    <div class="container">
        <section class="contact-section">
            <h1>Contact Us</h1>
            
            <div class="contact-details">
                <h2>Get in Touch</h2>
                <p><i class="fas fa-map-marker-alt"></i> Address: R.K.Desai Groups Of College, Koparli Road, Vapi 396191</p>
                <p><i class="fas fa-phone"></i> Phone: +1 (123) 456-7890</p>
                <p><i class="fas fa-envelope"></i> Email: contact@rkdesai.org</p>
            </div>

            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>

            <div class="map">
                <h2>Our Location</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3740.160360036991!2d72.92705607219418!3d20.376277009874915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be0ce4c67d2eeeb%3A0x8f71c45a6dc39c7f!2sRK%20Desai%20College!5e0!3m2!1sen!2sin!4v1724005578535!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            
            </div>
        </section>
    </div>
</body>
</html>
