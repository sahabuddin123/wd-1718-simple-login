<?php
session_start();
if($_SESSION['loggin'] == "" ||  $_SESSION['username'] == ""){
    header('location: index.php');
}
else{



      echo "<h1>Welcome to Deshboard</h1>";
      ?>
    <img src="<?php echo $_SESSION['image']; ?>" alt="!">
<?php

  }

  ?>