<?php
session_start();
include_once "dbh2.inc.php";

if($_POST['action'] == 'Yes'){
    
    $stmt = $conn->prepare("UPDATE restaurant SET RestaurantName=?, Description=? WHERE RestaurantID=?");
    $stmt->bind_param("sss", $ResName, $ResDesc, $ResID);
    
    $ResID = $_POST['ResID'];
    
    $ResDesc = $_POST['ResDescription'];
    $ResName = $_POST['RestaurantName'];
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
    exit();

}else if ($_POST['action'] == 'No'){
    
    header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
    exit();
    

}else{
    echo "Invalid Option";
}

?>