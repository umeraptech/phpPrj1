<?php
    session_start();
    require 'connect.inc.php';

    if (!isset( $_SESSION["user"])) {
        header('location: login.php');
    }
    if ($_SESSION["type"] != "admin") {
        header('location: login.php');
    }


    if (isset($_REQUEST['btnUpload'])) {
      // echo "yahoo";
        $name = (isset($_POST["txtName"]))?$_POST["txtName"]:"";
        $rate =(isset($_POST["txtRate"]))?$_POST["txtRate"]:"";

        $imageFile = $_FILES['txtPic']['name'];
        $type = $_FILES['txtPic']['type'];
        $size = $_FILES['txtPic']['size'];
        $temp = $_FILES['txtPic']['tmp_name'];

        $prodMsg = NULL;
        $prodMsg .= "product name is {'$name'}<br>product rate is {'$rate'} <br>";
        $prodMsg .= "request obj name is {'$imageFile'} of type {'$type'} of size {'$size'} with uploaded name is {'$temp'}";


        $path = "upload/".$imageFile;


        if (!empty($temp)) {
            if ($type == "image/jpg" || $type=="image/jpeg") {
                if (!file_exists($path)) {
                    //$mg = fopen($temp,'rb');
                    move_uploaded_file($temp,$path);
                }else {
                    $errorMsg = "File already exists ..... rename file";
                }
            }else{

                $errorMsg = "Only jpeg/jpg allowed";
            }
        }else{
            $errorMsg = "Please Select Image";
        }

        if (!isset($errorMsg)) {
            $qry = "insert into product (productName,	productRate,	productPic) values ('$name','$rate','$imageFile')";
            if ( $db->exec($qry)) {
                $successMsg = "File uploaded and record saved";
            }else{
                $errorMsg .= "<br>Error in saving record";
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Admin Panel</h1>       
            <p>Welcome: <span style=" text-transform: uppercase; color: red;}"><?php echo  $_SESSION["user"]; ?></span> </p>     
        </div>
        <div>
            <div class="row">
                <div class="col-md-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div><label for="txtName">Product Name</label></div>
                            <input class="form-control" type="text" placeholder="Enter Product Name" name="txtName">
                        </div>
                        <div class="form-group">
                            <div><label for="txtRate">Product Rate</label></div>
                            <input class="form-control" type="text" placeholder="Enter Product Rate" name="txtRate">
                        </div>
                        <div class="form-group">
                            <label for="my-input">Select Picture</label>
                            <input type="file" class="form-control" accept="image/*" name="txtPic" placeholder="Select Any Pic"/>
                        </div>
                        <div>
                           <button name="btnUpload" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-8">
                   <div class="table-responsive">
                    <?php
                        $qry = "Select * from product order by productid desc";
                        $sno = 1;
                    ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $rslt = $db->query($qry);
                                    foreach ($rslt as $row) {
                                        echo "<tr>";
                                ?>
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $row['productName'] ?></td>
                                    <td><?php echo $row['productRate'] ?></td>
                                    <td><img src="<?php echo 'upload/'.$row['productPic']; ?>" alt="<?php echo $row['productName'] ?>" width="100" height="auto"/></td>                                        
                                <?php
                                    $sno++;
                                    echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                   </div>
                </div>
            </div>
            <div style="margin-top: 15px">
                <?php 
                    if (!empty($prodMsg)) {
                         
                ?>
                
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Inserted Info! </strong><?php echo $prodMsg; ?>
                </div>
                
                <?php
                    }
                ?>
            </div>
            <div style="margin-top: 15px">
                <?php 
                    if (!empty($errorMsg)) {
                         
                ?>
                
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error! </strong><?php echo $errorMsg; ?>
                </div>
                
                <?php
                    }
                ?>
            </div>
            <div style="margin-top: 15px">
                <?php 
                    if (!empty($successMsg)) {
                         
                ?>
                
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success! </strong><?php echo $successMsg; ?>
                </div>
                
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>