
if($rows==1 && password_verify($user->password, $row['password'])){
<?php
  // Initialiser la session
  session_start();

  // Détruire la session.
  if(session_destroy())
  {
    // Redirection vers la page de connexion
    header("Location: auth.php");
  }
?>
