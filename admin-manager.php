<?php

include_once "dbh2.inc.php";

if($_POST['action']== 'Remove User'){
    
    $stmt = $conn->prepare("DELETE from auth_user WHERE id=?");
    $stmt->bind_param("s", $UsrID);
   
    $UsrID = $_POST['UsrID'];

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: http://localhost:10080/cmt322_project/AdminMainPage.php");
    exit();


}else if($_POST['action']== 'Remove Restaurant'){
    
    $stmt = $conn->prepare("DELETE from restaurant WHERE RestaurantID=?");
    $stmt->bind_param("s", $ResID);
    
    $ResID = $_POST['ResID'];
    
    $stmt->execute();
    

    $stmt = $conn->prepare("DELETE from auth_user WHERE id=?");
    $stmt->bind_param("s", $UsrID);
    $UsrID = $_POST['UsrID'];
    
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: http://localhost:10080/cmt322_project/AdminMainPage.php");
    exit();


}else if($_POST['action']== 'Remove Rider'){
    
    $stmt = $conn->prepare("DELETE from auth_user WHERE id=?");
    $stmt->bind_param("s", $UsrID);
    
    $UsrID = $_POST['UsrID'];
    
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: http://localhost:10080/cmt322_project/AdminMainPage.php");
    exit();


}else if($_POST['action']== 'Place Order'){
    
    header("Location: http://localhost:10080/cmt322_project/AdminMainPage.php");
    exit();

}else {
    echo "An Error has occured.";
}

?>