<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="images/login1.png" alt="Logo" width="60" class="me-2">
      <span class="fw-bold">MyWebsite</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php 
        // when user are not login see this 
        if(!isset($_SESSION['user_details'])):?>
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
       <!-- When user are login ssee this  -->
        <?php else: ?>
        <li class="nav-item"><a class="nav-link active" href="showdata.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
       <?php endif ?>
      </ul>
    </div>
  </div>
</nav>
