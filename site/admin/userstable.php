<?php
require('../config.php');
require('../class.php');


if(isset($_POST["roleup"])){

    $user = new USER();


  $user->role = $_POST['role'];
  $user->role = mysqli_real_escape_string($conn, $user->role);

  $user->id = $_REQUEST['idrole'];


  $user->Updaterole($conn);


}


if (isset($_POST['userdel'])) {

  $user = new USER();
  $user->id = $_REQUEST['idrole'];
  $res = $user->deleteuser($conn);

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
      <th class="th-sm">Name
      </th>
      <th class="th-sm">Username
      </th>
      <th class="th-sm">Email
      </th>
      <th class="th-sm">Role
      </th>
      <th class="th">Manage
      </th>
    </tr>
  </thead>
  <tbody>

    <?php


    $sqluser = "SELECT * FROM user";
    $resultuser = $conn->query($sqluser);
    while($user = $resultuser->fetch_assoc() ) {?>





    <tr>
      <td><?php echo $user['id'] ?></td>
      <td><?php echo $user['firstname'] ?> <?php echo $user['lastname'] ?></td>
      <td><?php echo $user['username'] ?></td>
      <td><?php echo $user['email'] ?></td>
      <td>
        <form class="" method="post">
        <input type="text" name="idrole" value="<?php echo $user['id'] ?>" style="display:none;">
        <select class="" name="role">
          <?php  if ($user['role']=='user') {  ?>
            <option value="<?php echo $user['role'] ?>" selected><?php echo $user['role'] ?></option>
            <option value="admin">Admin</option>
        <?php  }else {  ?>
          <option value="<?php echo $user['role'] ?>" selected><?php echo $user['role'] ?></option>
          <option value="user">user</option>
    <?php    }  ?>
        </select>
        </td>
      <td>
        <input type="submit" class="text-primary font-weight-bold" name="roleup" value="Update" style="background:none;border:none;"><span class="font-weight-bold">/</span>
        <input type="submit" class="text-danger font-weight-bold" name="userdel" value="Delete" style="background:none;border:none;">
        </form>
      </td>
    </tr>
    <?php }?>






  </tbody>
</table>




<script type="text/javascript">
$(document).ready(function () {
$('#dtBasicExample').DataTable();
$('.dataTables_length').addClass('bs-select');
});
</script>


  </body>
</html>
