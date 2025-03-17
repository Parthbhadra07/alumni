
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R.K. Desai Groups of College</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <style>
    .body{
        overflow-x: hidden;     }
        .img{
            width: 500px;
            height: fit-content;
        }
        .carousel-inner{
            position: relative;
            left: 30vw;
            top: 1vh;
            bottom: 200px;

        }
        .carousel-control-next-icon{
            position: relative;
            right: 20vw;
            top: 7vh;

        }
        .carousel-control-prev-icon{
            position: relative;
            left: 20vw;
            top: 7vh;
        }
    
   </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div id="carouselExampleDark" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img class="img" src="./img/07.jpg" class="d-block" alt="...">
      
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img class="img" src="./img/08.jpg" class="d-block" alt="...">
      
    </div>
    <div class="carousel-item">
      <img class="img" src="./img/07.jpg" class="d-block" alt="...">
      
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    


<?php include 'footer.php'; ?>
</body>
</html>
