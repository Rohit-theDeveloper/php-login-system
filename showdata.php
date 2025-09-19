<?php
session_start();
require_once('db/connection.php');

if(!isset($_SESSION['user_details'])){
    header('Location:login.php');
}
// Handel Showing Data in Table...

 $user_details = $_SESSION['user_details'];
  $users = [];
 if($user_details->role == 'admin'){
    $sql = "SELECT * FROM user_data where role != 'admin'";
    $exec = $con->query($sql);
   

    while($data = $exec->fetch_object()){
        $users[] = $data;
    }
 }elseif ($user_details->role == "users"){
    $sql = "SELECT * FROM user_data WHERE id = $user_details->id";
    $exec = $con->query("$sql");
    // echo "<pre>";
    // print_r($exec->fetch_object());
    // exit;
    while($data = $exec->fetch_object()){
        $users[] = $data;
    }

 }
 // Handel Delete Operation....
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
  $uid = mysqli_real_escape_string($con ,$_GET['id']);
 $sql = "DELETE FROM user_data WHERE id = $uid";
 $delete = $con->query($sql);

 if($delete){
  $_SESSION['success'] = 'Data Deleted Sucessfully..';
  
  header('Location:showdata.php');
}else {
  $_SESSION['error']=  'Something Went Wrong';
  header('Location:showdata.php'); 
}
 exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }
    .navbar {
      background: #212529;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
    }
    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    .table-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-action {
      margin: 0 5px;
    }
  </style>
</head>
<body>

<!-- 🔹 Header/Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">My Dashboard</a>
    <div class="d-flex align-items-center ms-auto">
      <span class="me-3 text-white">
        <?= $user_details->fname . " " . $user_details->lname ?> (<?= ucfirst($user_details->role) ?>)
      </span>""
      <?php
      if($user_details->role == 'admin'){
        $profileimg = "images/admin.png";
      }else{
        $profileimg =  "uploads/".$user_details->profile;
       
      }
      ?>  
      <img src="<?= $profileimg?>" alt="Profile" class="profile-pic me-3">
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- 🔹 Main Content -->
<div class="container mt-5">
  <div class="table-container">
    <h3 class="mb-4 text-center"><?= $user_details->role == 'admin'? "User Data" : "Own Data" ?></h3>
    <table class="table table-striped table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Gender</th>
          <th>State</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>

      <?php 
      if(count ($users) > 0 ) { ?>
      <tbody>
    <?php  
    $i =1;
    foreach($users as $user){
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo $user->fname?></td>
          <td><?php echo $user->lname?></td>
          <td><?php echo $user->email?></td>
          <td><?php echo $user->contact?></td>
          <td><?php echo $user->gender?></td>
          <td><?php echo $user->state?></td>
          <td><?php echo $user->role?></td>
          <td>
            <a href="update.php?id=<?php echo $user->id; ?>" class="btn btn-sm btn-warning btn-action mb-2">Update</a>
            <?php  if($user_details->role == 'admin'): ?>
            <a href="showdata.php?action=delete&id=<?php echo $user->id;?>" class="btn btn-sm btn-danger btn-action">Delete</a>
            <?php endif ?>
          </td>
    <?php } ?>   
      </tbody><?php }  else { ?>
    <!-- No Record Found Message -->
    <div class="text-center">
  <div class="alert alert-info d-inline-block px-5 py-2 fs-5 fw-bold text-center rounded-pill">
    🚫 No Records Found
  </div>
</div>
  <?php } ?>
    </table>
  </div>
</div>
<?php if (!empty($_SESSION['success'])):
    $msg = $_SESSION['success'];
    unset($_SESSION['success']); 
?>
<script>
  // PHP value ko JS string me inject kar diya
  setTimeout(()=>{
      alert("<?= $msg ?>");

  },1000);
</script>
<?php   endif?>
<!-- Handel Delete Sucess Messsage  -->
<?php 
if(!empty($_SESSION['success'])):?>
<script>
  alert("<?= $_SESSION['sucess'] ?>");
</script>
<?php unset($_SESSION['sucess']) ; endif ?>
<!-- Handel Delete Error Message -->
<?php if (!empty($_SESSION['error'])): ?>
<script>
  alert("<?= $_SESSION['error'] ?>");
</script>
<?php unset($_SESSION['error']); endif; ?>

</body>
</html>
