<?php

//  include('includes/header.php');
 session_start();
 require_once('db/connection.php');

if(isset($_GET['id'])){
 $uid = mysqli_real_escape_string($con, $_GET['id']);
 $sql = "SELECT * FROM user_data WHERE id = $uid";
 $exec =  $con->query($sql);
  if($exec->num_rows > 0 ){
    $data = $exec->fetch_object();
  }
 }
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 if(isset($_POST['update'])){
  try {
    $path = 'uploads/'; 
    $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
    $filename = $_POST['fname']."-".date('YmdHis').".".$extension; 
    $profile = (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) ? $filename : $data->profile;

   $update_data = [
    'fname' =>  mysqli_real_escape_string($con,$_POST['fname']),
    'lname' =>  mysqli_real_escape_string($con,$_POST['lname']),
    'email' =>  mysqli_real_escape_string($con,$_POST['email']),
    'password' =>  mysqli_real_escape_string($con,$_POST['password']),
    'dob' =>  mysqli_real_escape_string($con,$_POST['dob']),
    'contact' =>  mysqli_real_escape_string($con,$_POST['contact']),
    'gender' =>  mysqli_real_escape_string($con,$_POST['gender']),
    'address' =>  mysqli_real_escape_string($con,$_POST['address']),
    'state' =>  mysqli_real_escape_string($con,$_POST['state']),
    'profile' => mysqli_real_escape_string($con, $profile),
    'role' => 'users'
   ];
    
  // make query..
  
    $sql = "UPDATE user_data SET";
    foreach($update_data as $key => $value){
      $sql.=" $key = '$value',";
    }
    
    $sql = rtrim($sql , ',');
    $sql .= " WHERE id = '$uid'";
    
  $update = $con->query($sql);
 if($update){ 
      if(!is_null($profile)){
        move_uploaded_file($_FILES['profile']['tmp_name'] , $path.$filename);
      } 
       $_SESSION['Success'] = "Data Update Successfully";
       header('Location:showdata.php');
       exit;
     } else {
      $_SESSION['error'] = "Something Went wrong";
      header('Location:registration.php');
      exit;
     }

  }catch (Exception $ex) {
     
          $_SESSION['error'] = $ex->getMessage();
           header('Location:registration.php');
           exit;
          
        }
      }
 ?>

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
        <h2 class="text-center mb-4">Update Info</h2>

        <!-- Handel Message Of Session . -->

        <?php

        // Success Message
        if(isset($_POST['update'])){
          if(!empty($_SESSION['Success'])){
            echo "<div id='flash-msg' class='alert alert-success text-center mb-3'>".$_SESSION['Success']."</div>";
            
           
          }
        
      //  Error Message
          if(!empty($_SESSION['error'])){
            echo "<div id='flash-msg' class='alert alert-danger text-center mb-3'>".$_SESSION['error']."</div>";
            unset($_SESSION['errror']);
          }
        }
          

        ?>
        <form method="POST"enctype="multipart/form-data">
          
          <!-- First & Last Name -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label ">First Name</label>
              <input type="text" name="fname"  value="<?php echo $data->fname?>" class="form-control form-input" placeholder="Enter your first name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="lname" value="<?php echo $data->lname?>"  class="form-control form-input" placeholder="Enter your last name" required>
            </div>
          </div>

          <!-- Email & Password -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="<?php echo $data->email?>"  class="form-control form-input" placeholder="Enter your email" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input type="password" name="password"  value="<?php echo $data->password?>"  class="form-control form-input" placeholder="Enter a strong password" required>
            </div>
          </div>

          <!-- Contact & Gender -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Contact</label>
              <input type="text" name="contact"  value="<?php echo $data->contact?>" class="form-control form-input" placeholder="Enter contact number" required>
            </div>
            <div class="col-md-6">
              <label class="form-label d-block"  value = "<?php echo $data->gender;?>">Gender</label>
              <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="male" class="form-check-input" required
               <?php 
                if($data->gender =='MALE'){echo 'checked';}
                ?>
                
                >
                <label class="form-check-label text-white">Male</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" name="gender" value="female" class="form-check-input" required 
                 <?php 
                if($data->gender =='FEMALE'){echo'checked';}
                ?>
                
                >
                <label class="form-check-label text-white">Female</label>
              </div>
            </div>
          </div>

          <!-- Address & State -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input type="text" name="address" value="<?php echo $data->address ?>" class="form-control form-input" placeholder="Enter your address" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">State</label>
              <select name="state" class="form-select form-input" required>
                <option value="disabled">-- Select State --</option>
                <option <?php if($data->state =="Delhi")
                       echo "selected";?>>Delhi</option>
                <option
                <?php if($data->state =="Maharashtra")
                       echo "selected";?>>Maharashtra</option>
                <option
                <?php if($data->state =="Uttar Pradesh")
                       echo "selected";?>>Uttar Pradesh</option>
                <option
                <?php if($data->state =="Bihar")
                       echo "selected";?>>Bihar</option>
                <option
                <?php if($data->state =="Karnataka")
                       echo "selected";?>>Karnataka</option>
              </select>
            </div>
          </div>


          <!-- Profile -->
           <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Profile Picture</label>
                <img src="<?php echo "uploads/".$data->profile.""?>" height="100px" width="100px">"
                <input type="file" name="profile" class="form-control form-input">
            </div>
            <div class="col-md-6">
              <label class="form-label">D.O.B</label>
              <input type="date" name="dob" 
              value ="<?php echo date('Y-m-d', strtotime(str_replace('-', '/', $data->dob))); ?>" class="form-control form-input"required>
            </div>
          </div>

          <!-- Buttons -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5" name="update">Update</button>
            <a href="showdata.php" class="btn btn-outline-light px-5 ms-2">Dashboard</a>
          </div>
        </form>
      </div>
    </div>
  </div>
 

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
  </script>
  <script>
  setTimeout(() => {
    let msg = document.querySelector('#flash-msg');
    if (msg) {
      msg.style.display = 'none';
    }
  }, 1000);
</script>
</body>
</html>
