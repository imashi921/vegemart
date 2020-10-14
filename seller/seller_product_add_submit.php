<?php
    include('../database/dbconfig.php') ;
          
    if(empty(session_id())){
        session_start();
    }
          
    $target_dir = "../images/products/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
              
    // if everything is ok, try to upload file
    else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } 
        else {
            $message = base64_encode(urlencode("Sorry, there was an error uploading your file."));
            header('Location:seller_product_add.php?msg=' . $message);
            exit();
            }
    }
          
    //Uploading to Database
    if (isset($_POST['submit'])){
        $imageName = $_FILES["fileToUpload"]["name"];
        $imageData = $_FILES["fileToUpload"]["tmp_name"];
        $imageType = $_FILES["fileToUpload"]["type"];
        $productName = $_POST['productName'];
        $quantity = $_POST['quantity'];  
        $minPrice = $_POST['minPrice'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $sellerID = $_SESSION["loggedInSellerID"];                            
                    
        if (isset($_POST['ad'])){
            $adID = rand(); 
            $insertProduct = "INSERT INTO `products` (`sellerID`,`name`,`quantity`,`minPrice`,`imageName`,`address1`,`address2`,`city`,`adID_fk`) VALUES ('".$sellerID."','".$productName."','".$quantity."','".$minPrice."','".$imageName."','".$address1."','".$address2."','".$city."','".$adID."');";
            $advertise =  "INSERT INTO `advertisements` (`adID`) VALUES ('".$adID."');";      
            if (mysqli_query($con, $insertProduct) === TRUE && mysqli_query($con, $advertise) === TRUE) {                            
                $message = base64_encode(urlencode("Product Added."));
                header('Location:seller_home.php?msg=' . $message);
                exit();
            }
            else{                           
                $message = base64_encode(urlencode("SQL Error while Registering"));
                header('Location:seller_product_add.php?msg=' . $message);
                exit();
            } 
        }

        else{  
            $insertProduct = "INSERT INTO `products` (`sellerID`,`name`,`quantity`,`minPrice`,`imageName`,`address1`,`address2`,`address3`) VALUES ('".$sellerID."','".$productName."','".$quantity."','".$minPrice."','".$imageName."','".$address1."','".$address2."','".$address3."');";                         
            if (mysqli_query($con, $insertProduct) === TRUE) {                            
                $message = base64_encode(urlencode("Product Added."));
                header('Location:seller_home.php?msg=' . $message);
                exit();
            }
            else {                           
                $message = base64_encode(urlencode("SQL Error while Registering"));
                header('Location:seller_product_add.php?msg=' . $message);
                exit();
            } 
        }               
    }

    mysqli_close($con);
?>

