<?php
    include ('../../config/dbconfig.php');
    include ('../../src/session.php');  
    //if(isset($_GET['res_id'])){
        $id=$_SESSION["loggedInSellerID"]; ;
        //  $retriewMenu = "SELECT * FROM restaurant WHERE res_id = ".$_GET['res_id'];
        $retriewMenu = "SELECT * FROM client WHERE id = ".$id;
        $resultMenu = mysqli_query($con,$retriewMenu);
        while($rowProduct  = mysqli_fetch_assoc($resultMenu)){  
            include ('../../public/seller/seller_dashboard/map.php');
        }
        
        // } 
        mysqli_close($con);
    

?>