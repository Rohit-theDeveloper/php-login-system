<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <?php
   include('includes/header.php');
  ?>

  <!-- Carousel -->
  <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/image1.jpg" class="d-block w-100 " alt="Slide 1">
      </div>
      <div class="carousel-item">
        <img src="images/image2.jpg" class="d-block w-100 " alt="Slide 2">
      </div>
      <div class="carousel-item">
        <img src="images/image3.jpeg" class="d-block w-100 " alt="Slide 3">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Cards Section -->
  <section class="container py-5">
    <h2 class="text-center mb-5">Our Services</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body">
            <h5 class="card-title">Web Development</h5>
            <p class="card-text">Modern, responsive websites tailored to your business needs.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body">
            <h5 class="card-title">Mobile Apps</h5>
            <p class="card-text">Custom Android & iOS apps with sleek UI/UX.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body">
            <h5 class="card-title">UI/UX Design</h5>
            <p class="card-text">Intuitive interfaces and engaging user experiences.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Text Section -->
  <section class="bg-light py-5">
    <div class="container text-center">
      <h2 class="mb-4">Why Choose Us?</h2>
      <p class="lead">We combine creativity, technology, and expertise to deliver top-notch solutions that drive success.
        Our team is passionate about creating user-friendly and efficient platforms for businesses of all sizes.</p>
    </div>
  </section>

  <!-- Footer -->
 <?php 
 
 include('includes/footer.php')
 ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
