<?php
require('../config.php');
require('../class.php');

if (isset($_POST['topicdel'])) {

  $topic = new TOPIC();
  $topic->id = $_REQUEST['idtopic'];
  $res = $topic->deletetopic($conn);

}

?>


<?php



if (isset($_POST['addtopic'])){



$topic = new TOPIC();



$topic->name = stripslashes($_REQUEST['name']);
$topic->name = mysqli_real_escape_string($conn, $topic->name);

$topic->img = stripslashes($_REQUEST['logo']);
$topic->img = mysqli_real_escape_string($conn, $topic->img);


$query = "INSERT into topic (name, img)
          VALUES ('$topic->name', '$topic->img')";

$res = mysqli_query($conn, $query);



}


if (isset($_POST['edittopic'])){



$topic = new TOPIC();



$topic->name = stripslashes($_REQUEST['name']);
$topic->name = mysqli_real_escape_string($conn, $topic->name);

$topic->img = stripslashes($_REQUEST['logo']);
$topic->img = mysqli_real_escape_string($conn, $topic->img);

$topic->id = $_POST['idtopic'];


$query = "UPDATE topic SET  name = '" . $topic->name . "' , img = '". $topic->img ."' WHERE id = '" . $topic->id . "'";

$res = mysqli_query($conn, $query);



}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  </head>
  <style media="screen">
  table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
  </style>
  <body>



    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th">Id
      </th>
      <th class="th">Name
      </th>
      <th class="th">Logo
      </th>
      <th class="th">Posts
      </th>
      <th class="th">Manage
      </th>
    </tr>
  </thead>
  <tbody>

    <?php


    $sqltopic = "SELECT * FROM topic";
    $resulttopic = $conn->query($sqltopic);
    while($topic = $resulttopic->fetch_assoc() ) {?>

    <tr>
      <td><?php echo $topic['id'] ?></td>
      <td><?php echo $topic['name'] ?></td>
      <td><?php echo $topic['img'] ?></td>
      <td>
        <?php
        $idto = $topic['id'];
        $sqlres= "SELECT * FROM post WHERE topic_id = '$idto'";
        $resultres=$conn->query($sqlres);
        $comms = mysqli_num_rows($resultres);
        echo $comms;
         ?>
      </td>
      <td>
        <form method="post">
        <input type="text" name="idtopic" value="<?php echo $topic['id'] ?>" style="display:none;">
        <input type="submit" class="text-primary font-weight-bold" name="topicup" value="Update" style="background:none;border:none;"><span class="font-weight-bold">/</span>
        <input type="submit" class="text-danger font-weight-bold" name="topicdel" value="Delete" style="background:none;border:none;">
        </form>
        </td>

    </tr>
    <?php }?>

  </tbody>
</table>


<center>
<?php if(isset($_POST['topicup'])){ ?>
  <?php

    $idd = $_REQUEST['idtopic'];
   $sqltopic = "SELECT * FROM topic WHERE id = '" . $idd ."' ";
   $resulttopic = $conn->query($sqltopic);
   $topic = $resulttopic->fetch_assoc()?>
  <div class="col-6 mt-4">
    <h4 class="mt-2 mb-4">Edit topic</h4>
  <form class="border rounded mb-0 p-5" method="post">
    <input type="text" name="idtopic" value="<?php echo $topic['id'] ?>" style="display:none;">
    <div class="form-group">
        <input class="form-control" name="name" value="<?php echo $topic['name'] ?>" placeholder="Name" required>
    </div>
    <div class="form-group">
      <small id="emailHelp" class="form-text text-muted float-left">Copy the < i > tag from <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a>.</small>
        <input type="text" class="form-control" name="logo" value='<?php echo $topic['img'] ?>' placeholder='Logo : e.g. <i class="fab fa-html5"></i>' required>
    </div>
    <div class="flexbtn">
        <input type="submit"  name="edittopic" class="btn btn-primary" value="Edit topic">
    </div>
  </form>
  </div>


<?php }else{ ?>


  <div class="col-6 mt-4">
    <h4 class="mt-2 mb-4">Add a new topic</h4>
  <form class="border rounded mb-0 p-5" method="post">
    <div class="form-group">
        <input class="form-control" name="name" placeholder="Name" required>
    </div>
    <div class="form-group">
      <small id="emailHelp" class="form-text text-muted float-left">Copy the < i > tag from <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a>.</small>
        <input type="text" class="form-control" name="logo" placeholder='Logo : e.g. <i class="fab fa-html5"></i>' required>
    </div>
    <div class="flexbtn">
        <input type="submit"  name="addtopic" class="btn btn-primary" value="Add topic">
    </div>
  </form>
  </div>

<?php } ?>

</center>




<script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
$('.dataTables_length').addClass('bs-select');
});
</script>


  </body>
</html>
