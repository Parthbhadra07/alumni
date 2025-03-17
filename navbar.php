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
            <a href="events.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'events.php') ? 'active' : ''; ?>">Cources</a>
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
            
            <a href="./editalumniform.php">Edit Alumni Form</a>
            
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
