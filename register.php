<?php
include_once('./config/db.php');
include_once('./config/fileupload.php');
if(isset($_REQUEST['submit'])){

    $msg = [];
    // validition
    if($_REQUEST['username'] == ""){
        $msg['username'] = "Please Enter Your Username";
    }
    else{
        $username = $_REQUEST['username'];
    }
    if($_REQUEST['email'] == ""){
        $msg['email'] = "Please Enter Your Email";
    }
    else{
        $email = $_REQUEST['email'];
    }
    if($_REQUEST['password'] == ""){
        $msg['password'] = "Please Enter Your Password";
    }
    
    if($_REQUEST['repassword'] != $_REQUEST['password']){
        $msg['repassword'] = "Password not match!";
    }
    
    if($_FILES['file'] == ""){
        $msg['image'] = "Please inser Your Image";
    }

    if($_REQUEST['username'] != "" && $_REQUEST['email'] != "" && $_REQUEST['password'] != "" && $_REQUEST['repassword'] != "" && $_REQUEST['password'] == $_REQUEST['repassword'] && $_FILES['file'] != ""){
       /**
        * Database Connection Check
        */
        if($dbh){
            /**
             * Insert Query
             */
            $sql = "INSERT INTO `user`(`username`, `email`, `password`, `image`) VALUES (?,?,?,?)";
            /**
             * Prepared Statement
             */
            $stmt = $dbh->prepare($sql);
            /**
             * Bind Param
             */
            $stmt->bindParam(1, $_REQUEST['username']);
            $stmt->bindParam(2, $_REQUEST['email']);
            /**
             * Hash Password
             */
            $password = md5($_REQUEST['password']);
            $stmt->bindParam(3, $password);
            /**
             * File Upload
             */
            $upload = new upload();
            $upload->setFunctionVal();
            $stmt->bindParam(4, $upload->uploadfiles);
            /**
             * Execute All Data
             */
            if($upload->uploadFile()){
                if($stmt->execute()){
                    header('location: index.php');
                }
                else{
                    echo "Insert Fail";
                }
            }
            else{
                echo "File Upload Fali";
            }
            
        }
        else{
            echo "Database Connection Fail";
        }
        
    }
    // else{
    //     echo "<script>alert('filed Empty');</script>";
    // }
   


 
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
    <title>Register - Educafe</title>
    <style>
        .login-content .login-box{
            min-height:700px;
            margin-bottom: 100px;
        }
        .mt-3{
            margin-top:2rem !important;
        }
    </style>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Vali</h1>
      </div>
      <div class="login-box">
        <form class="login-form" action="" method="POST" enctype="multipart/form-data">

          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
          <div class="form-group">
            <label class="control-label" for="username">USERNAME</label>
            <input type="text" class="form-control" id="username" placeholder="username" autofocus="false" name="username" value="<?php if(isset($username)){echo $username;}?>">
            <span class="text-danger"><?php if(isset($msg['username'])){echo $msg['username'];} ?></span>
          </div>
          <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input type="email" id="email" class="form-control" placeholder="Email" autofocus="false" name="email" value="<?php if(isset($email)){echo $email;}?>">
            <span class="text-danger"><?php if(isset($msg['email'])){echo $msg['email'];} ?></span>
        </div>
          <div class="form-group">
            <label class="control-label" for="password">PASSWORD</label>
            <input class="form-control" name="password" type="password" id="password" placeholder="Password">
            <span class="text-danger"><?php if(isset($msg['password'])){echo $msg['password'];} ?> </span>
        </div>
           <div class="form-group">
            <label class="control-label" for="repassword">Re-PASSWORD</label>
            <input class="form-control" name="repassword" id="repassword" type="re-type password" placeholder="Re-PASSWORD">
            <span class="text-danger"><?php if(isset($msg['repassword'])){echo $msg['repassword'];} ?> </span>
        </div>
           <div class="form-group">
            <label class="control-label" for="file">Profile Image</label>
            <input class="form-control" type="file" name="file" id="file">
            <span class="text-danger"><?php if(isset($msg['image'])){echo $msg['image'];} ?> </span>
          </div>
          
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN UP</button>
          </div>
          <a href="index.php" class="text-right mt-3"> Already have an account ?</a>
        </form>
        
          <!-- <h3 class="login-head">Already have an account ?</h3> -->
          
     
      </div>
      
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
