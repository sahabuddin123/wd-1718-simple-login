<?php
session_start();
if(isset($_SESSION['loggin']) && isset($_SESSION['username'])){
  header('location: deshboard.php');
}
require_once('./config/db.php');
if(isset($_REQUEST['submit'])){
  if($dbh){
    /**
     * Input validation
     */
   
    if($_REQUEST['username'] == ""){
      $userNull = "Please Enter your uername or email";
    }
    else{
      $userEmail = $_REQUEST['username'];
    }
    if($_REQUEST['password'] == ""){
      $passNull = "Please Enter your password";
    }
    
    if($_REQUEST['username'] != '' && $_REQUEST['password'] != ''){
      /**
       * User Select Query
       */
      $sql = "SELECT `id` FROM `user` WHERE username = :username OR email = :username";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(":username",$_REQUEST['username']);
      // $stmt->bindParam(":email",$_REQUEST['username']);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      /**
       * Valid User Condition Check
       */
      // var_dump($row);
      if(empty($row)){
        $UserFlash = "Invalid Username or Email";
      }
      else{
        extract($row);
        /**
         * Password Select Query
         */
        $sql2 = "SELECT * FROM `user` WHERE `id` = :id";
        $stmt = $dbh->prepare($sql2);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($result);
        $userpassword = md5($_REQUEST['password']);
        if($password != $userpassword){
          $PasswordFlash = "Invalid Password!";
        }
        else{
         session_start();
        //  $_SESSION['loggin'] = true;
         $_SESSION['username'] = $username;
         $_SESSION['image'] = $image;
         header('location: deshboard.php');
        }
      }
      
    }
    
  }
}
?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - Vali Admin</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>POS</h1>
      </div>
      <div class="login-box">
        <form class="login-form" action="" method="post">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" name="username" placeholder="Username or Email" autofocus="false" autocomplete="false" value="<?php if(isset($userEmail)){ echo $userEmail;} ?>">
            <span class="text-danger"><?php 
            if(isset($UserFlash)){
              echo $UserFlash."<br>";
            }
            if(isset($userNull)){
              echo $userNull;
            }
            
            ?></span>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
            <span class="text-danger"><?php 
            if(isset($PasswordFlash)){
              echo $PasswordFlash."<br>";
            }
            if(isset($passNull)){
              echo $passNull;
            }
            
            ?></span>
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button type="submit" name="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>