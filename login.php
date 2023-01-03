<?php
require 'connect.inc.php';

session_start();
if (isset($_REQUEST['btnSubmit'])) {
   $userName =  (isset($_POST["txtLogin"]))?$_POST["txtLogin"]:"";
   $userPass =  (isset($_POST["txtPass"]))? md5($_POST["txtPass"]):"";

   $successMsg = "";
   $error = "";
    //user123$, umer
    $query = "";
   if (!empty($userName) && !empty($userPass)) {
   // $successMsg = "user id is {$userName} and password is {$userPass}" ;
    $query = "select loginName, loginType, loginPassword from login where loginName = '{$userName}' and loginPassword = '{$userPass}'";
    $rslt= $db->query($query);
    print_r ($rslt);
   if (!empty($rslt)) {
    foreach($rslt as $row){
      if ($userName == $row['loginName'] && $userPass == $row['loginPassword']) {
        //$successMsg = "You are authenticated" ;
        $_SESSION["user"]=$row['loginName'];
        $_SESSION["type"] = $row['loginType'];

        if ($row['loginType'] == 'user') {
          header('location: product.php');
        }else if($row['loginType'] == 'admin'){
          header('location: admin.php');
        }

      } else{
        $error = "Credential doesn't match";
       }
    }
    }
   
   }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Login Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
       <div>
       <form method="post" action="">
          
          
          <label for="input-id" class="col-sm-2"></label>
          <input type="text" name="txtLogin" placeholder="Enter User ID" class="form-control" required>
          <label for="input-id" class="col-sm-2"></label>
          <input type="password" name="txtPass" placeholder="Enter User Password"  class="form-control" required>
          <br>
          <div>
            <input type="submit" class="btn btn-success" name="btnSubmit"  value="login" /> &nbsp;
            <a href="register.php" class="btn btn-info">Register</a>
            
            </div>
            
        </form>
       </div>
       <br>
       <div>
            <?php
                if (!empty($successMsg))
                 {                  
            ?>
                
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Succes!</strong> <?php echo $successMsg; ?>
                </div>
                
            <?php
                }
            ?>
       </div>
       <div>
            <?php
                if (!empty($query))
                 {                  
            ?>
                
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Info!</strong> <?php echo $query; ?>
                </div>
                
            <?php
                }
            ?>
       </div>
       <div>
            <?php
                if (!empty($error))
                 {                  
            ?>
                
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> <?php echo $error; ?>
                </div>
                
            <?php
                }
            ?>
       </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>