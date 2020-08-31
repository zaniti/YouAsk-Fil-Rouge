<?php
require('config.php');
require('class.php');
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(isset($_SESSION["username"])){
    header("Location: home.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouAsk</title>
    <link rel="icon" type="image/png" href="css/imgs/favicon.png"/>
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/auth.css" />
  </head>
  <body>



<!-- **************** -->

<div class="wrapper">

    <div class="title">
        <h1>You Ask</h1>
        <p>A place to share knowledge and better understand the code</p>
    </div>

    <div class="forms">

        <form  method="post" class="signup">
            <h4>Sign Up</h4>

            <div class="row">
                <div class="col">
                <input type="text" class="form-control" name="firstname" placeholder="First name" required>
                </div>
                <div class="col">
                <input type="text" class="form-control" name="lastname" placeholder="Last name" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="col">
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm" required>
                </div>
            </div>
            <div id="divID"></div>
            <div class="flexbtn">
                <input type="submit" name="register" class="btn btn-primary btn-signup" value="Sign Up">
            </div>


        </form>

        <div class="line"></div>

        <form  method="post" class="login">

            <h4>Login</h4>

            <div class="form-group">
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" required>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div id="logID"></div>
            <div class="flexbtn">
                <input type="submit"  name="login" class="btn btn-primary btn-login" value="Login">
            </div>

        </form>

        <div class="codebarre">
            <p>made with love by Zniti</p>
        </div>

    </div>


</div>

<!-- **************** -->



<?php


// SIGN UP

if(isset($_POST["register"])){

    $user = new USER();

  $user->firstname = stripslashes($_REQUEST['firstname']);
  $user->firstname = mysqli_real_escape_string($conn, $user->firstname);

  $user->lastname = stripslashes($_REQUEST['lastname']);
  $user->lastname = mysqli_real_escape_string($conn, $user->lastname);

  $user->username = stripslashes($_REQUEST['username']);
  $user->username = mysqli_real_escape_string($conn, $user->username);

  $user->email = stripslashes($_REQUEST['email']);
  $user->email = mysqli_real_escape_string($conn, $user->email);

  $user->password = stripslashes($_REQUEST['password']);
  $user->password = mysqli_real_escape_string($conn, $user->password);
  $user->hashedpassword = password_hash($user->password, PASSWORD_DEFAULT);


  $confirmpassword = stripslashes($_REQUEST['confirmpassword']);
  $confirmpassword = mysqli_real_escape_string($conn, $confirmpassword);

  $selectemail = mysqli_query($conn, "SELECT `email` FROM `user` WHERE `email` = '$user->email'") or exit(mysqli_error($conn));
  $selectusername = mysqli_query($conn, "SELECT `username` FROM `user` WHERE `username` = '$user->username'") or exit(mysqli_error($conn));

  if(mysqli_num_rows($selectemail)) {
    //   exit('This email is already being used');
    echo '<script type="text/javascript">';
    echo ' var div = document.getElementById("divID");';
    echo ' div.innerHTML = "Email is already in use!";';
    echo '</script>';
}else  if(mysqli_num_rows($selectusername)){
    echo '<script type="text/javascript">';
    echo ' var div = document.getElementById("divID");';
    echo ' div.innerHTML = "Username is already in use!";';
    echo '</script>';
        }
   else if ($user->password === $confirmpassword) {


    $query = "INSERT into `user` (username, password, email, firstname, lastname, photo , role)
              VALUES ('$user->username', '$user->hashedpassword', '$user->email', '$user->firstname' , '$user->lastname','newuser.png', 'user')";

  $res = mysqli_query($conn, $query);
    if($res){
        header("Location: home.php");
    }

}else {
    echo '<script type="text/javascript">';
    echo ' var div = document.getElementById("divID");';
    echo ' div.innerHTML = "Passwords does not match!";';
    echo '</script>';

}
alert("You have been registred successfully");
}




?>







<?php

// LOGIN

if (isset($_POST['login'])){

    $user = new USER();

  $user->email = stripslashes($_REQUEST['email']);
  $user->email = mysqli_real_escape_string($conn, $user->email);
  $user->password = stripslashes($_REQUEST['password']);
  $user->password = mysqli_real_escape_string($conn, $user->password);


    $query = "SELECT * FROM `user` WHERE email='$user->email'";

  $result = mysqli_query($conn,$query) or die(mysql_error());
  $rows = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

  if ($rows==1 && password_verify($user->password, $row['password'])) {

      $_SESSION['id']    = $row['id'];
      $_SESSION['email'] = $user->email;
      $_SESSION['username'] = $row['username'];
      $_SESSION['photo'] = $row['photo'];
      $_SESSION['firstname'] = $row['firstname'];
      $_SESSION['lastname'] = $row['lastname'];

      header("Location: home.php");
  }else{
    echo '<script type="text/javascript">';
    echo ' var div = document.getElementById("logID");';
    echo ' div.innerHTML = "Incorrect email or password!";';
    echo '</script>';

  }

}


 ?>


</body>
</html>
