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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>YouAsk | Ask</title>
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
    <link rel="stylesheet" href="css/main.css" />
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
              alt="avatar image" height="35"  width="35" style="object-fit:cover;">
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




<?php

// ADD POST
if (isset($_POST['edit'])){



   $post = new POST();



   $post->title = stripslashes($_REQUEST['title']);
   $post->title = mysqli_real_escape_string($conn, $post->title);

   $post->content = stripslashes($_REQUEST['content']);
   $post->content = mysqli_real_escape_string($conn, $post->content);

   $post->code = stripslashes($_REQUEST['code']);
   $post->code = mysqli_real_escape_string($conn, $post->code);


   $post->date = date("Y.m.d");

   $post->topic_id = stripslashes($_REQUEST['topic']);
   $post->topic_id = mysqli_real_escape_string($conn, $post->topic_id);


   $post->id = $_GET['postid'];




 $post->updatepost($conn);


}

?>


                      <div class="container mt-4">
                      <div class="col-8 contentask">
                        <center>
                          <h2>Edit question</h2><br>
                        </center>



                        <form class="border p-5" method="POST">
                          <label>Topic*</label>
                         <select class="browser-default custom-select mb-4" name="topic" required>
                            <option value="" disabled selected>Choose a topic</option>
                            <?php
                                $sqltop = "SELECT * FROM topic";
                                $resulttop = $conn->query($sqltop);
                                while($topic = $resulttop->fetch_assoc() ) {?>
                                <option value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                            <?php }?>

                        </select>
                         <!-- title -->
                         <?php
                         $idd = $_GET['postid'];
                         $sqlpost = "SELECT * FROM post WHERE id ='" . $idd . "' ";
                         $resultpost = $conn->query($sqlpost);
                         $post = $resultpost->fetch_assoc();
                        ?>
                         <label>Title*</label>
                         <input type="text" id="defaultContactFormName" value="<?php echo $post['title'] ?>" class="form-control mb-4" placeholder="Question in general" name="title" required>
                         <!-- desciption -->
                         <label>Question*</label>
                         <div class="form-group">
                             <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" placeholder="Explain more" name="content" required><?php echo $post['content'] ?></textarea>
                         </div>
                         <!-- Code -->
                         <label>Code</label>
                         <div class="form-group">
                             <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3" placeholder="Your code here" name="code"><?php echo $post['code'] ?></textarea>
                         </div>
                         <!-- add button -->
                         <center>
                           <input class="btn btn-primary btn-md rounded-pill" name="edit" type="submit" value="Edit">
                         </center>

                         </form>
                         </div>
                        </div>






  </body>
</html>
