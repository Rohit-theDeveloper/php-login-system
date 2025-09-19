<?php
session_start();
require_once('db/connection.php');

if (isset($_POST['login'])) {

  try {
    // verify mail 
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $verify_user = $con->query("SELECT * FROM user_data WHERE email = '$email' And password = '$password'");
    if ($verify_user->num_rows < 1) {
      $_SESSION['error'] = "Wrong Email id and Password try again !";
      header('Location:login.php');
      exit;
    }

    if (!empty($email) && !empty($password)) {
      $sql = "SELECT * FROM user_data WHERE email = '$email' And password = '$password'";
      $exec = $con->query($sql);

      if ($exec->num_rows > 0) {
        $_SESSION['user_details'] = $exec->fetch_object();
        $_SESSION['success'] = "Login Successfull";
        header('Location:showdata.php');
        exit;
      }

    }

  } catch (Exception $ex) {
    $_SESSION['error'] = $ex->getMessage();
    header('Location:login.php');
    exit;
  }

}

?>

<!--  including header..  -->
<?php
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #121212;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-card {
      background: #141414;
      border: none;
      border-radius: 15px;
      padding: 30px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.8);
    } */

    .login-card h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      color: #fff;
    }

    .form-label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #ddd;
    }

    .form-control {
      background: #1e1e1e;
      border: 1px solid #333;
      border-radius: 8px;
      color: #fff;
      padding: 10px;
      transition: 0.3s;
    }

    .form-control:focus {
      background: #252525;
      border-color: #0d6efd;
      box-shadow: none;
      color: #fff;
    }

    .btn-custom {
      background: #0d6efd;
      border: none;
      border-radius: 8px;
      padding: 10px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-custom:hover {
      background: #084298;
    }

    .text-link {
      text-align: center;
      margin-top: 15px;
    }

    .text-link a {
      color: #0d6efd;
      text-decoration: none;
      transition: 0.3s;
    }

    .text-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <h2>Login</h2>
      <!-- Handel Session Message -->
      <?php
      // Error Message
      if (!empty($_SESSION['error'])) {
        echo "<div id='flash-msg' class='alert alert-danger text-center mb-3'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
      }
      // Success Message
      
      if (!empty($_SESSION['success'])) {
        echo "<div id='flash-msg' class='alert alert-success text-center mb-3'>" . $_SESSION['success'] . "</div>";

      }

      ?>
      <form method="POST" action="login.php">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password"
            required>
          <span id="togglePassword"
            style="position:absolute; top:70%; right:35%; transform:translateY(-50%); cursor:pointer;">
            👁️
          </span>
        </div>
        <button type="submit" class="btn btn-custom w-100" name="login">Login</button>
        <div class="text-link">
          <p>Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
      </form>
    </div>
  </div>
<!--  including Footer -->
  <?php
  include('includes/footer.php')
    ?>

  <script>
    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    let visible = false;

    togglePassword.addEventListener('click', () => {
      password.type = 'text';
      visible = true;
    })

    togglePassword.addEventListener('dblclick', () => {
      password.type = 'password';
      visible = false;
    })
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>