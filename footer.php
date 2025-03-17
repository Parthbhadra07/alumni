<?php
// PHP section for any server-side logic (if needed)
?>
<!DOCTYPE html>
<html lang="en">
<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Document</title>

          <style>/* Footer styles */
        .footer {
            background: #333; /* Dark background */
            color: #fff;
            padding: 2em 1em;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer .footer-top {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 1em;
            flex-wrap: wrap;
        }

        .footer .footer-top div {
            flex: 1;
            margin: 0.5em;
            min-width: 200px;
        }

        .footer .footer-top h2 {
            margin-bottom: 1em;
            font-size: 1.5em;
        }

        .footer .footer-top .footer-links,
        .footer .footer-top .social-icons {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
        }

        .footer .footer-top .footer-links a,
        .footer .footer-top .social-icons a {
            color: #fff;
            transition: color 0.3s;
        }

        .footer .footer-top .footer-links a:hover,
        .footer .footer-top .social-icons a:hover {
            color: #007bff; /* Primary color on hover */
        }

        .footer .footer-bottom {
            font-size: 0.9em;
            margin-top: 1em;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer .footer-top {
                flex-direction: column;
                align-items: center;
            }

            .footer .footer-top div {
                margin: 1em 0;
                text-align: center;
            }

            .footer .footer-top .footer-links,
            .footer .footer-top .social-icons {
                align-items: center;
                gap: 1em;
            }
        }</style>
</head>
<body>
       
<footer class="footer">
    <div class="footer-top">
        <div>
            <h2>Contact Us</h2>
            <p>Call Us: (123) 456-7890</p>
            <p>Email: info@rkdesai.edu</p>
        </div>
        <div class="footer-links">
            <h2>Quick Links</h2>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="events.php">Events</a>
            <a href="members.php">Alumni</a>
            <a href="contact.php">Contact</a>
        </div>
        <div class="social-icons">
            <h2>Follow Us</h2>
            <a href="#" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="LinkedIn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 R.K. Desai Groups of College. All rights reserved.</p>
    </div>
</footer>   
</body>
</html>