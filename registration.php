<?php
session_start();
require_once('db/connection.php');
  

// handel profile ..
if (isset($_POST['register'])) {
  try {
    // email exist check..
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = $con->query("SELECT id FROM user_data where email = '$email'");
    if ($check_email->num_rows > 0) {
      $_SESSION['error'] = "Email Already Exist.";
      header("Location:registration.php");
      exit;
    }

    // image file handle here
    $path = 'uploads/';
    $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
    $filename = $_POST['fname'] . "-" . date('YmdHis') . "." . $extension;
    $profile = file_exists($_FILES['profile']['tmp_name']) ? $filename : null;

    // data insertion here..
    $insert_data = [
      'fname' => mysqli_real_escape_string($con, $_POST['fname']),
      'lname' => mysqli_real_escape_string($con, $_POST['lname']),
      'email' => mysqli_real_escape_string($con, $_POST['email']),
      'password' => mysqli_real_escape_string($con, $_POST['password']),
      'dob' => mysqli_real_escape_string($con, $_POST['dob']),
      'contact' => mysqli_real_escape_string($con, $_POST['contact']),
      'gender' => mysqli_real_escape_string($con, $_POST['gender']),
      'address' => mysqli_real_escape_string($con, $_POST['address']),
      'state' => mysqli_real_escape_string($con, $_POST['state']),
      'profile' => $profile,
      'role' => 'users'
    ];

    // create Query...
    $key = implode(',', array_keys($insert_data));
    $val = implode("','", array_values($insert_data));
    $sql = "INSERT INTO user_data ($key) VALUES ('$val')";

    // execute query 
    $insert = $con->query($sql);
    if ($insert) {
      if (!is_null($profile)) {
        move_uploaded_file($_FILES['profile']['tmp_name'], $path . $filename);
      }
      $_SESSION['Success'] = "Data Saved Successfully";
      header('Location:registration.php');
      exit;
    } else {
      $_SESSION['error'] = "Data insertion failed";
      header('Location:registration.php');
      exit;
    }

  } catch (Exception $ex) {

    $_SESSION['error'] = $ex->getMessage();
    header('Location:registration.php');
    exit;

  }
}
?>

<!-- Include header -->
<?php
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-dark text-white">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card form-card shadow-lg w-100" style="max-width: 700px;">
      <div class="card-body">
        <h2 class="text-center mb-4">User Registration</h2>

        <!-- Handel Message Of Session . -->
        <?php
        // Success Message
        if (!empty($_SESSION['Success'])) {
          echo "<div id='flash-msg' class='alert alert-success text-center mb-3'>" . $_SESSION['Success'] . "</div>";
          unset($_SESSION['Success']);
        }
        // Error Message
        if (!empty($_SESSION['error'])) {
          echo "<div id='flash-msg' class='alert alert-danger text-center mb-3'>" . $_SESSION['error'] . "</div>";
          unset($_SESSION['error']);
        }
        ?>
        <form method="POST" action="registration.php" enctype="multipart/form-data">
         <!-- First & Last Name -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label ">First Name</label>
              <input type="text" name="fname" class="form-control form-input" placeholder="Enter your first name"
                required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="lname" class="form-control form-input" placeholder="Enter your last name"
                required>
            </div>
          </div>
          <!-- Email & Password -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control form-input" placeholder="Enter your email" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input type="password" id="password" name="password" class="form-control form-input" placeholder="Enter a strong password" required>
                <span id="togglePassword" style="position:absolute; top:37%; right:30px; transform:translateY(-50%); cursor:pointer;">
                  👁️
                </span>
            </div>
          </div>
          <!-- Contact & Gender -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Contact</label>
              <input type="text" name="contact" class="form-control form-input" placeholder="Enter contact number"
                required>
            </div>
            <div class="col-md-6">
              <label class="form-label d-block">Gender</label>
              <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="male" class="form-check-input" required>
                <label class="form-check-label text-white">Male</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="female" class="form-check-input">
                <label class="form-check-label text-white">Female</label>
              </div>
            </div>
          </div>
          <!-- Address & State -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control form-input" placeholder="Enter your address"
                required>
            </div>
            <div class="col-md-6">
              <label class="form-label">State</label>
              <select name="state" class="form-select form-input" required>
                <option value="">-- Select State --</option>
                <option>Delhi</option>
                <option>Maharashtra</option>
                <option>Uttar Pradesh</option>
                <option>Bihar</option>
                <option>Karnataka</option>
              </select>
            </div>
          </div>
          <!-- Profile -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Profile Picture</label>
              <input type="file" name="profile" class="form-control form-input" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">D.O.B</label>
              <input type="date" name="dob" class="form-control form-input" required>
            </div>
          </div>
          <!-- Buttons -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5" name="register">Register</button>
            <a href="login.php" class="btn btn-outline-light px-5 ms-2">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
  </script>
  <!-- Script for #flash-msg -->
  <script>
    setTimeout(() => {
      let msg = document.querySelector('#flash-msg');
      if (msg) {
        msg.style.display = 'none';
      }
    }, 1000);
  </script>
 <!-- Script for password visibile or not  -->
  <script>
  const password = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');
  let visible = false ;

  togglePassword.addEventListener('click',() => {
         password.type = 'text';
         visible = true;
  })

  togglePassword.addEventListener('dblclick', () => {
      password.type = 'password';
         visible = false;
  })
  </script>
</body>
</html>