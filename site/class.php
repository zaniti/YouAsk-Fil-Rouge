<?php

    class USER {
        public $id;
        public $username;
        public $email;
        public $password;
        public $firstname;
        public $lastname;
        public $photo;
        public $role;


        public function Updateemail($conn){
          $update_query = mysqli_query($conn,"UPDATE user SET  email = '" . $this->email . "' WHERE id = '" . $this->id . "'");

          header("Location: profilesettings.php");

        }


        public function Updatename($conn){
          $update_query = mysqli_query($conn,"UPDATE user SET  firstname = '" . $this->firstname . "' , lastname = '". $this->lastname ."' WHERE id = '" . $this->id . "'");

            header("Location: profilesettings.php");


        }


        public function Updateusername($conn){
          $update_query = mysqli_query($conn,"UPDATE user SET username = '" . $this->username . "' WHERE id = '" . $this->id . "'");

           header("Location: profilesettings.php");

        }


        public function ChangePhoto($conn){

           $update_query = mysqli_query($conn,"UPDATE user SET photo = '" . $this->photo . "' WHERE id = '" .  $_SESSION['id']  . "'");


        }

        public function ChangePassword($conn){

           $update_query = mysqli_query($conn,"UPDATE user SET password = '" . $hashedpassword . "' WHERE id = '" . $this->id . "'");

           header("Location: profilesettings.php");
        }

        public function Updaterole($conn){
          $update_query = mysqli_query($conn,"UPDATE user SET role = '" . $this->role . "' WHERE id = '" . $this->id . "'");



        }

        public function deleteuser($conn){
          $sqldel = "DELETE FROM user WHERE id=$this->id";
            return $result = $conn->query($sqldel);

        }


}

    class POST{
        public $id;
        public $title;
        public $content;
        public $code;
        public $upvote;
        public $downvote;
        public $date;
        public $report;
        public $user_id;
        public $topic_id;


        public function deletepost($conn){
          $sqlcdel = "DELETE FROM response WHERE post_id = $this->id";
          $result = $conn->query($sqlcdel);
          $sqldel = "DELETE FROM post WHERE id=$this->id";
            return $result = $conn->query($sqldel);

        }

        public function updatepost($conn){
          $update_query = mysqli_query($conn,"UPDATE post SET title = '" . $this->title . "', content = '" . $this->content . "', code = '" . $this->code . "', date = '" . $this->date . "', topic_id = '" . $this->topic_id . "'  WHERE id = '" . $this->id . "'");

           header("Location: myquestions.php");

        }
    }


    class TOPIC{
        public $id;
        public $name;
        public $img;


        public function deletetopic($conn){
          $sql = "SELECT * FROM post WHERE topic_id = '$this->id'";
           $result = $conn->query($sql);

         while($post = $result->fetch_assoc() ) {

         $update_query1 = mysqli_query($conn,"DELETE FROM response WHERE post_id = '{$post["id"]}'");
        $update_query4 = mysqli_query($conn,"DELETE FROM votes WHERE id_post='{$post["id"]}'");

          $update_query2 = mysqli_query($conn,"DELETE FROM post WHERE id = '{$post["id"]}'");
          // $sqlpdel = "DELETE FROM post WHERE topic_id = $this->id";
          // $result = $conn->query($sqlpdel);
          // $sqldel = "DELETE FROM topic WHERE id=$this->id";
          //   return $result = $conn->query($sqldel);
          $sqldel = "DELETE FROM topic WHERE id=$this->id";
          return $result = $conn->query($sqldel);
        }
      }

        public function updatetopic($conn){


        }


    }


    class RESPONSE{
        public $id;
        public $content;
        public $code;
        public $date;
        public $valid;
        public $user_id;
        public $post_id;


        public function deleteresp($conn){

        }

        public function updateresp($conn){


        }

    }
?>
