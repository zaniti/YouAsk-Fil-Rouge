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


  if (isset($_GET['del'])) {

    $post= new POST();
    $post->id = $_GET['del'];
    $res = $post->deletepost($conn);

  }
?>
<?php

// ADD POST

if (isset($_POST['respond'])){



$response = new RESPONSE();



$response->content = stripslashes($_REQUEST['content']);
$response->content = mysqli_real_escape_string($conn, $response->content);

$response->code = stripslashes($_REQUEST['code']);
$response->code = mysqli_real_escape_string($conn, $response->code);


$response->date = date("Y.m.d");




$response->user_id = $_SESSION['id'];
$response->post_id = $_GET['postID'];




$query = "INSERT into response (content, code,  date, user_id, post_id)
          VALUES ('$response->content', '$response->code' , '$response->date', '$response->user_id','$response->post_id')";

$res = mysqli_query($conn, $query);
if($res){

    header('Location: post.php?postID='{$_GET["postID"]});

}else {
    echo '<script type="text/javascript">';
    echo ' alert("incorrect. ")';
    echo '</script>';
}

}

$vote = 0;
if (isset($_POST['upvote'])) {
  $_SESSION['voteup'] = $_POST['upvote'];
  // echo $_POST['upvote'];
  $postID = $_GET['postID'];
  $userID = $_SESSION['id'];
  $vote += 1;
  $sql= "SELECT id_post, vote_score FROM votes WHERE id_post = '$postID' AND id_user = '$userID'";
  $result = $conn->query($sql);
  $test = $result->fetch_assoc();

  if(empty($test)){

    // echo "for yes: rani khawyaaa emptyy";
            $sql = "INSERT INTO votes (id_post, id_user, vote_score) VALUES ('$postID', '$userID', '$vote')";
            $conn->query($sql);
            $_SESSION['yes'] = 'yes';
        }else if(!empty($test) && !isset($_SESSION['yes']) && !isset($_SESSION['no'])){
          // echo "for yes: rani ma khawyach o makin la yes la no ylh dkhlt";
          $_SESSION['yes'] = 'yes';
          unset($_SESSION['no']);
          $stl = "SELECT vote_score FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
          $result = $conn->query($stl);
          $votee = $result->fetch_assoc();
          $votee = $votee['vote_score'];
          if($votee == 1){
            $vote = $votee -1;
          }else{
            $vote = $votee + 2;
          }

          $sql = "UPDATE votes SET vote_score = $vote WHERE id_user = '$userID' AND id_post = '$postID'";
          $conn->query($sql);

        }else if(!isset($_SESSION['yes']) && isset($_SESSION['no']) && $_POST['upvote'] == $_SESSION['votedown']){
          // echo "for yes: makinach yes o kina no ghadi n9os 2 postid: " . $postID . 'session id: ' .$_SESSION['id-post'];
            $_SESSION['yes'] = 'yes';
            unset($_SESSION['no']);
            $stl = "SELECT vote_score FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
            $result = $conn->query($stl);
            $votee = $result->fetch_assoc();
            $votee = $votee['vote_score'];
            $vote = $votee + 2;
            $sql = "UPDATE votes SET vote_score = $vote WHERE id_user = '$userID' AND id_post = '$postID'";
            $conn->query($sql);

        }else if(isset($_SESSION['yes'])  || $_POST['upvote'] != $_SESSION['votedown']){
          // echo "for yes: kina yes fach atwarak 3liya an7ayad vote dyalha";
            $sql = "DELETE FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
            $conn->query($sql);
            unset($_SESSION['yes']);
        }
}


if (isset($_POST['downvote'])) {
  $_SESSION['votedown'] = $_POST['downvote'];
  $postID = $_GET['postID'];
  $userID = $_SESSION['id'];
  $vote -= 1;
  $sql= "SELECT id_post, vote_score FROM votes WHERE id_post = '$postID' AND id_user = '$userID'";
  $result = $conn->query($sql);
  $test = $result->fetch_assoc();

        if(empty($test)){
          // echo "for NO: rani khawyaaa emptyy";
            $sql = "INSERT INTO votes (id_post, id_user, vote_score) VALUES ('$postID', '$userID', '$vote')";
            $conn->query($sql);
            $_SESSION['no'] = 'no';

        }else if(!empty($test) && !isset($_SESSION['no']) && !isset($_SESSION['yes'])){

          // echo "for NO: rani ma khawyach o makin la yes la no ylh dkhlt";
          $_SESSION['no'] = 'no';
          unset($_SESSION['yes']);
          $stl = "SELECT vote_score FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
          $result = $conn->query($stl);
          $votee = $result->fetch_assoc();
          $votee = $votee['vote_score'];
          if($votee == -1){
            $vote = $votee +1;
          }else{
            $vote = $votee -2;
          }
          $sql = "UPDATE votes SET vote_score = $vote WHERE id_user = '$userID' AND id_post = '$postID'";
          $conn->query($sql);
        }else if(!isset($_SESSION['no']) && isset($_SESSION['yes']) && $_SESSION['voteup'] == $_POST['downvote'] ){

          // echo "for NO: makinach no o kina yes ghadi n9os 2 postid: " . $postID . 'session id: ' .$_SESSION['id-post'];
            $_SESSION['no'] = 'no';
            unset($_SESSION['yes']);
            $stl = "SELECT vote_score FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
            $result = $conn->query($stl);
            $votee = $result->fetch_assoc();
            $votee = $votee['vote_score'];
            $vote = $votee - 2;
            $sql = "UPDATE votes SET vote_score = $vote WHERE id_user = '$userID' AND id_post = '$postID'";
            $conn->query($sql);

        }else if(isset($_SESSION['no']) || $_SESSION['voteup'] != $_POST['downvote']){
          // echo "for NO: kina no fach atwarak 3liya an7ayad vote dyalha";
            $sql = "DELETE FROM votes WHERE id_user = '$userID' AND id_post = '$postID'";
            $conn->query($sql);
            unset($_SESSION['no']);
        }
}



if (isset($_POST['valid'])) {
  $respoID = $_REQUEST['respoID'];

  $query = "UPDATE response SET valid = 1 WHERE id = '$respoID'";
  $conn->query($query);
  }

if (isset($_POST['notvalid'])) {
    $respoID = $_REQUEST['respoID'];

    $query = "UPDATE response SET valid = 0 WHERE id = '$respoID'";
    $conn->query($query);
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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/code.css" />
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
          $sqlpost = "SELECT post.*,user.firstname,user.lastname,user.username,user.photo FROM post JOIN user ON post.user_id = user.id WHERE post.id = {$_GET['postID']} ";
          $resultpost = $conn->query($sqlpost);
          $post = $resultpost->fetch_assoc();
          $_SESSION['id-post'] = $post['id'];
          ?>

          <div class="question p-3">
                  <h2 class="mt-2 ml-2 mb-3"><?php echo $post['title'] ?></h2>
                  <div class="row">
                  <div class="col-1 updown">
                    <!-- buttons upvote -->
                    <form class="" method="POST">
                      <button type="submit" id="up" class="<?php echo $post['id'];?>" name="upvote" value="<?php echo $post['id'];?>" style="background:none;border:none;outline:none"><i class="fas fa-hand-point-up"></i></button>
                        <small><?php
                        $postID = $_GET['postID'];
                        $sql= "SELECT SUM(vote_score) FROM votes WHERE id_post = '$postID'";
                        $result = $conn->query($sql);
                        $totale = $result->fetch_assoc();
                        echo $totale['SUM(vote_score)'] ?? 0; ?></small>
                        <button type="submit" id="down" class="<?php echo $post['id'];?>" name="downvote" value="<?php echo $post['id'];?>" style="background:none;border:none;outline:none;"><i class="fas fa-hand-point-down"></i></button>
                    </form>

                    <!-- <a><i class="fas fa-hand-point-up"></i></a>
                    <small>20</small>
                    <a><i class="fas fa-hand-point-down"></i></a> -->
                  </div>
                  <div class="col pl-0">
                    <p class="content"><?php echo $post['content'] ?></p>
                    <div class="somsom">
                      <code contentEditable="true">
                        <p class="text-code" style="display: none;"><?php echo $post['code'] ?></p>
                      </code>
                    </div>

                  </div>
                  </div>
          </div>
          <h4>Answers :</h6>

            <?php
            $sqlresp = "SELECT response.*,user.firstname,user.lastname,user.username,user.photo FROM response JOIN user ON response.user_id = user.id WHERE response.post_id = {$_GET['postID']}";
            $resultresp = $conn->query($sqlresp);
            while($response = $resultresp->fetch_assoc() ) {?>


          <div class="question p-3">
            <div class="row" style="flex-wrap:nowrap;">
              <div class="info-preso ml-2">
                <img src="upload/<?php echo $response['photo'] ?>" class="rounded-circle z-depth-0"
                  alt="avatar image" height="45"  width="45" style="object-fit:cover;">
                  <div class="perso">
                    <div class="nameusername ml-2">
                      <h4 class="name"><?php echo $response['firstname'] ?> <?php echo $response['lastname'] ?><span class="date">.<?php echo $response['date'] ?></span></h4>
                      <span class="atn">@<?php echo $response['username'] ?></span>
                    </div>

                  </div>
              </div>




            </div>
                  <div class="row">
                  <div class="col-1 updown mr-4">

                    <?php if ($response['valid'] == 1) { ?>
                      <p class="hidden" id="nothidden" title="Question owner made this response valid"><i class="fas fa-check-circle"></i></p>
                <?php    } ?>



                      <?php
                      $sql = "SELECT user_id FROM post WHERE post.id = {$_GET['postID']}";
                      $result = $conn->query($sql);
                      $resultp = $result->fetch_assoc();

                      if ($resultp['user_id']==$_SESSION['id']) {?>

                        <?php if ($response['valid']==0) { ?>

                        <div class="updelete">
                          <form class="" method="post">
                            <input type="text" name="respoID" style="visibility:hidden;" value="<?php echo $response['id'] ?>">
                            <button type="submit" name="valid" style="background:none;border:none;color:grey;" title="Validate answer"><i class="fas fa-check"></i></button>
                          </form>
                        </div>
                      <?php }else { ?>
                        <div class="updelete">
                          <form class="" method="post">
                            <input type="text" name="respoID" style="visibility:hidden;" value="<?php echo $response['id'] ?>">
                            <button type="submit" name="notvalid" style="background:none;border:none;color:grey;" title="Unvalidated answer"><i class="fas fa-times"></i></button>
                          </form>
                        </div>
                    <?php  } ?>
                    <?php } ?>






                  </div>
                  <div class="col pl-0">

                    <p class="content"><?php echo $response['content'] ?></p>
                    <div class="somsom">
                      <code contentEditable="true">
                        <p class="text-code" style="display: none;"><?php echo $response['code'] ?></p>
                      </code>
                    </div>

                  </div>
                  </div>
          </div>
          <?php }?>
          <h4 style="margin: 20px 0;">Your Answer :</h4>
          <form  class="border p-5" method="POST">

            <!-- desciption -->
            <label>Response*</label>
            <div class="form-group">
                <textarea class="form-control rounded-1" id="exampleFormControlTextarea2" rows="3" placeholder="Your solution" name="content" required></textarea>
            </div>
            <!-- Code -->
            <label>Code</label>
            <div class="form-group">
                <textarea class="form-control rounded-1" id="exampleFormControlTextarea2" rows="3" placeholder="Your code here" name="code"></textarea>
            </div>
            <!-- add button -->
            <center>
              <input class="btn btn-primary btn-md rounded-pill" name="respond" type="submit" value="Respond !">
            </center>
          </form>

       </div>






  </div>
</div>

<?php
            $userID = $_SESSION['id'];
            $sql = "SELECT id_post, vote_score FROM votes WHERE id_user = '$userID'";
            $result = $conn->query($sql);
            $vote = $result->fetch_all(MYSQLI_ASSOC);
?>


<script>
       const down = document.querySelector('#down');
       const up = document.querySelector('#up');
       <?php foreach($vote as $v): ?>



        if(down.classList.contains(<?php echo $v['id_post'];?>)){
          let score = <?php echo $v['vote_score'] ?>;
                    if(score == -1){
                        down.style.color = "#dc3545";
                    }
        }

        if(up.classList.contains(<?php echo $v['id_post'];?>)){
          let score = <?php echo $v['vote_score'] ?>;
                    if(score == 1){
                      up.style.color = "#28a745";
                    }
       }


        <?php endforeach; ?>


</script>


<script type="text/javascript">
let p = document.querySelectorAll('.text-code');
for (var i = 0; i < p.length; i++) {
  let x = p[i];
const code = x.parentElement;
let text = x.textContent.split('\n');
text = text.filter(item => item);
console.log(text);
// console.log(code)
text.forEach(x =>{
    let html = `<p>${x}</p>`;
    code.innerHTML += html;
})
}
</script>



<!-- var allbuttons = document.querySelectorAll(".playy");
for (var i = 0; i < allbuttons.length; i++) {
  allbuttons[i].addEventListener('click', function() {
    var x = this.parentElement;

    var list = x.firstElementChild;
    list.play();
  });
} -->

  </body>
</html>
