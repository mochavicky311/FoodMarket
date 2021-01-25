<?php

include_once "dbh2.inc.php";

if($_POST['action'] == 'Yes'){
    
    $stmt = $conn->prepare("UPDATE product SET ProductName=?, ProductPrice=? WHERE ProductID=?");
    $stmt->bind_param("sss", $prodName, $prodPrice, $prodID);
    
    $prodID = $_POST['ProdId'];
    $prodName = $_POST['ProductName'];
    $prodPrice = $_POST['ProductPrice'];
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    header("Location: http://localhost:10080/322/ResMainPage.php");
    exit();

}else if ($_POST['action'] == 'No'){
    
    header("Location: http://localhost:10080/322/ResMainPage.php");
    exit();
    

}else{
    echo "Invalid Option";
}

?>