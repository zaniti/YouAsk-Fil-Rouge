<?php
require('config.php');
require('class.php');
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: auth.php");
    exit();
  }


?>
<?php



if(isset($_POST["updateemail"])){

    $user = new USER();


  $user->email = stripslashes($_REQUEST['email']);
  $user->email = mysqli_real_escape_string($conn, $user->email);


  $user->id = $_SESSION['id'];


  $user->Updateemail($conn);


}
?>


<?php



 if(isset($_POST["updatename"])){

     $user = new USER();

   $user->firstname = stripslashes($_REQUEST['firstname']);
   $user->firstname = mysqli_real_escape_string($conn, $user->firstname);

   $user->lastname = stripslashes($_REQUEST['lastname']);
   $user->lastname = mysqli_real_escape_string($conn, $user->lastname);


   $user->id = $_SESSION['id'];


 $user->Updatename($conn);



 }
 ?>


 <?php



  if(isset($_POST["updateusername"])){

      $user = new USER();

      $user->username = stripslashes($_REQUEST['username']);
      $user->username = mysqli_real_escape_string($conn, $user->username);


    $user->id = $_SESSION['id'];


  $user->Updateusername($conn);



  }
  ?>

  <?php



   if(isset($_POST["updatepass"])){

       $user = new USER();



     $user->id = $_SESSION['id'];



     $user->password = stripslashes($_REQUEST['password']);
     $user->password = mysqli_real_escape_string($conn, $user->password);
     $hashedpassword = password_hash($user->password, PASSWORD_DEFAULT);


     $confirmpassword = stripslashes($_REQUEST['confirmpassword']);
     $confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);


      if ($user->password === $confirmpassword) {

       $user->ChangePassword($conn,$hashedpassword);

     }else {
       echo '<script type="text/javascript">';
       echo ' alert ("Passwords does not match!");';
       echo '</script>';

   }

   }
 ?>

 <?php

 if(isset($_POST["editimg"])){

   $file_name = $_FILES['image']['name'];
   $file_type = $_FILES['image']['type'];
   $file_size = $_FILES['image']['size'];
   $file_tem_loc = $_FILES['image']['tmp_name'];
   $file_store = "upload/".$file_name;

   move_uploaded_file($file_tem_loc, $file_store);

   $user = new USER();

   $user->photo = $file_name;

   $user->ChangePhoto($conn);




}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouAsk | My Questions</title>
    <link rel="icon" type="image/png" href="css/imgs/favicon.png"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/uploadimg.css" />
  </head>
  <body>


    <!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-light white">
  <a href="home.php"><h1 class="logo mr-4 mt-2">YouAsk</h1> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item mr-2">
        <a class="nav-link" href="home.php"><i class="fa fa-home mr-2"></i>Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="myquestions.php"><i class="fa fa-edit mr-2"></i>My questions</a>
      </li>
    </ul>
    <div class="search">

      <form class="form-inline" action="search.php" method="POST" >
        <input id="myInput" type="text" class="form-control" name="search" placeholder="Search question">
        <button id="myBtn" type="submit" name="search-submit" style="display:none;">Search</button>
      </form>
    </div>
    <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item avatar mr-2 dropdown">
        <a class="nav-link p-0  dropdown-toggle" href="#" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <?php
          $sqluser = "SELECT * FROM user WHERE id = '{$_SESSION[ "id" ]}'";
          $resultuser = $conn->query($sqluser);
          while($user = $resultuser->fetch_assoc() ) {?>
            <img src="upload/<?php echo $user['photo'] ?>" class="rounded-circle z-depth-0"
              alt="avatar image" height="35" width="35" style="object-fit:cover;">
          <?php }?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary"
          aria-labelledby="navbarDropdownMenuLink-55">
          <a class="dropdown-item" href="myquestions.php">My questions</a>
          <a class="dropdown-item" href="profilesettings.php">Settings</a>
          <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </li>
    </ul>
    <a href="ask.php"><input class="btn btn-primary btn-sm rounded-pill" type="submit" value="Ask !"></a>
  </div>
</nav>
<!--/.Navbar -->



<div class="container-fluid containerall">

  <div class="row mt-5">
    <div class="col-sm-3 col-12">
      <?php
      $sqluser = "SELECT * FROM user WHERE id = '{$_SESSION[ "id" ]}'";
      $resultuser = $conn->query($sqluser);
      while($user = $resultuser->fetch_assoc() ) {?>

        <center>



        <form method="post" enctype="multipart/form-data">



          <div class="avatar-upload">
              <div class="avatar-edit">
                  <input type='file' id="imageUpload" name="image" accept=".png, .jpg, .jpeg" required/>
                  <label for="imageUpload"></label>
              </div>
              <div class="avatar-preview">
                  <div id="imagePreview" style="background-image: url(upload/<?php echo $user['photo'] ?>);">
                  </div>
              </div>
          </div>
          <center>
            <button class="roundedbtn mb-3" type="submit" name="editimg"><i class="fa fa-check" aria-hidden="true"></i></button>
          </center>
          </form>

          </center>


    </div>

    <div class="col">


          <div class="question edituserinfo">
                <div class="row mt-4 ml-2">
                  <div class="col-4">
                    <h6>Primary Email</h6>
                  </div>
                  <div class="col">
                    <h6><?php echo $user['email'] ?></h6>
                    <a href="#" data-toggle="modal" data-target="#emailmodal">Change email</a>
                  </div>
                </div>
                <hr>
                <div class="row mt-4 ml-2">
                  <div class="col-4">
                    <h6>Name</h6>
                  </div>
                  <div class="col">
                    <h6><?php echo $user['firstname'] ?> <?php echo $user['lastname'] ?></h6>
                    <a href="#" data-toggle="modal" data-target="#namemodal">Change name</a>
                  </div>
                </div>
                <hr>
                <div class="row mt-4 ml-2">
                  <div class="col-4">
                    <h6>Username</h6>
                  </div>
                  <div class="col">
                    <h6>@<?php echo $user['username'] ?></h6>
                    <a href="#" data-toggle="modal" data-target="#usernamemodal">Change username</a>
                  </div>
                </div>
                <hr>
                <div class="row mt-4 mb-4 ml-2">
                  <div class="col-4">
                    <h6>Password</h6>
                  </div>
                  <div class="col">
                    <a href="#" data-toggle="modal" data-target="#passmodal">Change password</a>
                  </div>
                </div>
          </div>
          <?php }?>
       </div>



       <!-- EmailModal -->
       <div class="modal fade" id="emailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">

         <div class="modal-dialog modal-dialog-centered" role="document">


           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Update email</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <form method="post">
             <div class="modal-body">
               <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" required>
             </div>
             <input class="btn btn-primary btn-sm rounded-pill float-right mr-4 mb-2" type="submit" name="updateemail" value="Update">
             </form>
           </div>
         </div>
       </div>

       <!-- NameModal -->
       <div class="modal fade" id="namemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">

         <div class="modal-dialog modal-dialog-centered" role="document">


           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Update Name</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <form method="post">
             <div class="modal-body">
               <div class="row">
                   <div class="col">
                   <input type="text" class="form-control" name="firstname" placeholder="First name" required>
                   </div>
                   <div class="col">
                   <input type="text" class="form-control" name="lastname" placeholder="Last name" required>
                   </div>
               </div>
             </div>
             <input class="btn btn-primary btn-sm rounded-pill float-right mr-4 mb-2" type="submit" name="updatename" value="Update">
             </form>
           </div>
         </div>
       </div>

       <!-- usernameModal -->
       <div class="modal fade" id="usernamemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">

         <div class="modal-dialog modal-dialog-centered" role="document">


           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Update Username</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <form method="post">
             <div class="modal-body">
               <input type="text" class="form-control" name="username" placeholder="Username" required>
             </div>
             <input class="btn btn-primary btn-sm rounded-pill float-right mr-4 mb-2" type="submit" name="updateusername" value="Update">
             </form>
           </div>
         </div>
       </div>

       <!-- PassModal -->
       <div class="modal fade" id="passmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">

         <div class="modal-dialog modal-dialog-centered" role="document">


           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Update Password</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <form method="post">
             <div class="modal-body">
               <div class="row">
               <div class="col">
                   <input type="password" class="form-control" name="password" placeholder="Password" required>
               </div>
               <div class="col">
                   <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm" required>
               </div>
               </div>
             </div>
             <input class="btn btn-primary btn-sm rounded-pill float-right mr-4 mb-2" type="submit" name="updatepass" value="Update">
             </form>
           </div>
         </div>
       </div>








  </div>
</div>






































<script type="text/javascript">
function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url('+e.target.result +')');
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
  }
}
$("#imageUpload").change(function() {
  readURL(this);
});
</script>




  </body>
</html>
