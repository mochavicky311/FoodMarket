<?php

include_once "dbh2.inc.php";

if($_POST['action'] == 'Yes'){
    
    $stmt = $conn->prepare("DELETE FROM product WHERE ProductID=?");
    $stmt->bind_param("s", $prodID);
    
    $prodID = $_POST['ProdId'];
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $file = $_POST['ImgPath'];
    if(unlink($file)){
        echo "img removed successfully";
    }else{
        echo "an Error occured";
    }
    
    header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
    exit();
    
 

}else if ($_POST['action'] == 'No'){
    
    header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
    exit();
    

}else{
    echo "Invalid Option";
}

?>