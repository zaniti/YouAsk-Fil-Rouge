<?php
require('../config.php');
require('../class.php');
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: ../auth.php");
    exit();
  }

  $roleuser = "SELECT role FROM user WHERE id = '{$_SESSION[ "id" ]}'";
  $resultuser = $conn->query($roleuser);
  while ($user = $resultuser->fetch_assoc()) {
    if ($user['role']!='admin') {
      header("Location: error.php");
    }
  }


  if (isset($_GET['del'])) {

    $post= new POST();
    $post->id = $_GET['del'];
    $res = $post->deletepost($conn);

  }

?>
<!DOCTYPE html>
<html lang="" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>YouAsk | Back Office</title>
    <link rel="icon" type="image/png" href="../css/imgs/favicon-white.png"/>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff">
      <script src="https://code.jquery.com/jquery-2.2.4.min.js" charset="utf-8"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js" charset="utf-8"></script>


      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
      <!-- Google Fonts -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
      <link rel="stylesheet" href="dashboard.css">
      <link rel="stylesheet" href="../css/main.css" />
  </head>

<body>

  <ul id="slide-out" class="side-nav fixed z-depth-2">
    <li class="center no-padding">
      <div class="blue-grey darken-3 darken-4 white-text" style="height: 180px;">
        <div class="row">
          <?php
          $sqluser = "SELECT * FROM user WHERE id = '{$_SESSION[ "id" ]}'";
          $resultuser = $conn->query($sqluser);
          while($user = $resultuser->fetch_assoc() ) {?>
            <img style="margin-top: 5%;object-fit:cover;" width="100" height="100" src="../upload/<?php echo $user['photo'] ?>" class="circle responsive-img" />

          <p style="margin-top: -13%;">
            <?php echo $user['firstname'] ?> <?php echo $user['lastname'] ?>
          </p>
          <?php }?>
        </div>
      </div>
    </li>

    <li id="dash_dashboard"><a class="waves-effect" href="users.php"><b>Manage users</b></a></li>

    <li id="dash_dashboard"><a class="waves-effect" href="topics.php"><b>Manage topics</b></a></li>

    <li id="dash_dashboard"><a class="waves-effect" href="reports.php"><b>Reported posts</b></a></li>

  </ul>

  <header>

    <nav class="blue-grey darken-3" role="navigation">
      <div class="nav-wrapper">
        <a data-activates="slide-out" class="button-collapse show-on-" href="#!"><img style="height: 30px;margin-top: 17px; margin-left: 17px;" src="../css/imgs/youask.gif" /></a>

        <ul class="right">
          <li>
            <a class='right' href='../logout.php'><i class=' material-icons'>input</i></a>
          </li>
        </ul>

        <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </nav>

    <nav>
      <div class="nav-wrapper blue-grey darken-3 darken-4">
        <a style="margin-left: 20px;" class="breadcrumb">Admin</a>
        <a class="breadcrumb">Reported posts</a>

        <div style="margin-right: 20px;" id="timestamp" class="right"></div>
      </div>
    </nav>
  </header>




  <main>
    <div class="row" style="height:100vh;margin:20px;">


      <div class="col-8">

            <?php
            $sqlpost = "SELECT post.*,user.firstname,user.lastname,user.username,user.photo FROM post JOIN user ON post.user_id = user.id WHERE report != 0 ";
            $resultpost = $conn->query($sqlpost);
            while($post = $resultpost->fetch_assoc() ) {?>

            <div class="question homeq">
                    <a href="../post.php?postID=<?php echo $post['id']; ?>"><div class="info-preso">
                      <img src="../upload/<?php echo $post['photo'] ?>" class="circle responsive-img"
                        alt="avatar image" height="45" width="45" style="object-fit:cover;">
                        <div class="perso">
                          <div class="nameusername ml-2" style="margin-left:10px;">
                            <h6 class="name"><?php echo $post['firstname'] ?> <?php echo $post['lastname'] ?><span class="date">.<?php echo $post['date'] ?></span></h6>
                            <span class="atn">@<?php echo $post['username'] ?></span>
                          </div></a>
                            <div class="updelete">
                                <a href="reports.php?del=<?php echo $post['id'] ?>"><i class="fas fa-trash mr-2" style="color: #c1c1c1;"></i></a>
                            </div>
                        </div>
                    </div>
                    <a href="../post.php?postID=<?php echo $post['id']; ?>"><div class="">
                      <h4><?php echo $post['title'] ?></h4>
                    </div></a>
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
                        <i class="fas fa-comment ml-2" style="color: grey;margin-left:5px;"></i> <?php echo $comms ?>

                      </div>
            </div>
            <?php }?>
         </div>


    </div>
  </main>





  <footer class="blue-grey darken-3 page-footer">
    <div class="footer-copyright">
      <div class="container">
         <span>Made By <a style='font-weight: bold;' href="https://github.com/zaniti" target="_blank">Zniti</a></span>
      </div>
    </div>
  </footer>



  <script type="text/javascript">
  $('.button-collapse').sideNav();

  $('.collapsible').collapsible();

  $('select').material_select();
  </script>


</body>

</html>
