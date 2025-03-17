 <?php
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - RK Desai College</title>
    
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
        .about-section {
            padding: 20px 0;
        }
        .about-section h2 {
            color: #333;
        }
        .about-section p {
            margin-bottom: 20px;
        }
        .team {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            width: 70%;
        }
        .team-member {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 10px;
            flex: 1 1 calc(33% - 40px);
            box-sizing: border-box;
        }
        .team-member img {
            size: fit;
            position: static;
            border-radius: 50%;
        }
        .team-member h3 {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    

    <div class="container">
        <section class="about-section">
            <h1>About Us</h1>
            <p>Welcome to RK Desai College! Established in [1999], our institution has been committed to providing quality education and fostering academic excellence.</p>
            <p>Our mission is to empower students with knowledge, skills, and values to excel in their chosen fields. We offer a diverse range of programs and opportunities to help students achieve their academic and personal goals.</p>
            <p>Our vision is to be a leading educational institution recognized for its commitment to innovation, excellence, and holistic development.</p>
        </section>

        <section class="about-section">
            <h2>Our History</h2>
            <p>RK Desai College was founded by [late Shri Ramanlal Kunvarji Desai] with a vision to create a learning environment that nurtures creativity, critical thinking, and leadership. Over the years, we have grown and evolved, adapting to the changing educational landscape while staying true to our core values.</p>
        </section>

        <section class="about-section">
            <h2>Our Team</h2>
            <div class="team">
                <div class="team-member">
                    <img src="img/05.png" alt="Team Member 1">
                    <h3>Dr. Mittal Shah</h3>
                    <p>Principal/Campus Director</p>
                    <p>Dr. Mittal shah is a seasoned educator with over 20 years of experience in academia. Her leadership has been instrumental in shaping the college's growth and success.</p>
                </div>
                <div class="team-member">
                    <img src="img/06.png" alt="Team Member 2">
                    <h3>Ms. Neha Patel</h3>
                    <p>Head of Department</p>
                    <p>Ms. Neha Patel leads the [Bca] with a passion for teaching and research. She is dedicated to fostering an engaging and supportive learning environment.</p>
                </div>
                
            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
