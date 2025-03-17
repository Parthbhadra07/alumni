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
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a styles.css file for custom styling -->
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
<?php include 'navbar.php'; ?>

    <div class="container">
        <section class="contact-section">
            <h1>Contact Us</h1>
            
            <div class="contact-details">
                <h2>Get in Touch</h2>
                <p><i class="fas fa-map-marker-alt"></i> Address: R.K.Desai Groups Of College koparli road , vapi 396191</p>
                <p><i class="fas fa-phone"></i> Phone: +1 (123) 456-7890</p>
                <p><i class="fas fa-envelope"></i> Email: contact@rkdesai.org</p>
            </div>

            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

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
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3740.160360036991!2d72.92705607219418!3d20.376277009874915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be0ce4c67d2eeeb%3A0x8f71c45a6dc39c7f!2sRK%20Desai%20College!5e0!3m2!1sen!2sin!4v1724005578535!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>

    
</body>
</html>
