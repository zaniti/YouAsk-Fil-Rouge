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

  if (isset($_POST['report'])) {
    $postid = $_REQUEST['idposst'];

    $query = "UPDATE post SET report = report + 1 WHERE id = '$postid'";
    $conn->query($query);
    $message = "Post reported successfuly";
    echo "<script type='text/javascript'>alert('$message');</script>";
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouAsk | Home</title>
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
        <a class="nav-link current" href="home.php"><i class="fa fa-home mr-2"></i>Home</a>
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



<div class="container-fluid containerall">

  <div class="row mt-5">
    <div class="col-3">
        <ul class="navbar-nav mr-auto">
            <?php
              $sqltop = "SELECT * FROM topic";
              $resulttop = $conn->query($sqltop);
              while($topic = $resulttop->fetch_assoc() ) {?>
              <li class="nav-item"><a class="nav-link" href="topicposts.php?topicid=<?php echo $topic['id']; ?>"><?php echo $topic['img'] ?> <?php echo $topic['name'] ?></a></li>
              <?php }?>
        </ul>
    </div>

    <div class="col">

          <?php
          $sqlpost = "SELECT post.*,user.firstname,user.lastname,user.username,user.photo FROM post JOIN user ON post.user_id = user.id";
          $resultpost = $conn->query($sqlpost);
          while($post = $resultpost->fetch_assoc() ) {?>

          <div class="question homeq">
                  <a href="post.php?postID=<?php echo $post['id']; ?>"> <div class="info-preso">
                    <img src="upload/<?php echo $post['photo'] ?>" class="rounded-circle z-depth-0"
                      alt="avatar image" height="45"  width="45" style="object-fit:cover;">
                      <div class="perso">
                        <div class="nameusername ml-2">
                          <h4 class="name"><?php echo $post['firstname'] ?> <?php echo $post['lastname'] ?><span class="date">.<?php echo $post['date'] ?></span></h4>
                          <span class="atn">@<?php echo $post['username'] ?></span>
                        </div>

                      </div>
                  </div>
                  <h4><?php echo $post['title'] ?></h4></a>
                  <div class="chat">

                    <?php
                    $idpo = $post['id'];

                    // $sql = "SELECT SUM(vote_score),SUM(`response`.`post_id`) FROM votes, response WHERE id_post = '$idpo' AND post_id = '$idpo'"
                    $sql= "SELECT SUM(vote_score) FROM votes WHERE id_post = '$idpo'";
                    $sqlres= "SELECT * FROM response WHERE post_id = '$idpo'";
                    $resultres=$conn->query($sqlres);
                    $comms = mysqli_num_rows($resultres);
                    $result = $conn->query($sql);
                    $totale = $result->fetch_assoc();?>

                      <i class="fas fa-arrow-up" style="color: grey;"></i> <?php echo $totale['SUM(vote_score)'] ?? 0; ?>
                      <i class="fas fa-comment ml-2" style="color: grey;"></i> <?php echo $comms ?>
                      <form method="post" style="float:right;">
                        <input type="text" name="idposst" value="<?php echo $post['id'] ?>" style="display:none;">
                        <button type="submit" name="report" style="background:none; border:none; outline:none;" title="Report post"><i class="fas fa-exclamation-circle ml-2" style="color: #c1c1c1;"></i></button>
                      </form>


                    </div>
          </div>
          <?php }?>
       </div>







  </div>
</div>


<script>
var input = document.getElementById("myInput");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("myBtn").click();
  }
});
</script>


  </body>
</html>
