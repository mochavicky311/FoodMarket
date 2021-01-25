<?php

include_once "dbh2.inc.php";

if($_POST['action']== 'Accept'){
    $stmt = $conn->prepare("UPDATE orderitem SET Status=?, RiderID=? WHERE OrderID=?");
    $stmt->bind_param("sss", $status, $riderID, $OrderID);
    // status 0 1 2 3 4
    // status 0 is pending
    //        1 is accepted
    //        2 is declined
    //        3 is pickedUp/delivering
    //        4 is completed
    $status = 'Delivering';
    $riderID = $_POST['RiderID'];
    $OrderID = $_POST['OrdID'];

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: http://localhost:10080/cmt322_project/RiderMainPage.php");
    exit();


}else if($_POST['action']== 'Delivered'){
    $stmt = $conn->prepare("UPDATE orderitem SET Status=? WHERE OrderID=?");
    $stmt->bind_param("ss", $status, $OrderID);
    // status 0 1 2 3 4
    // status 0 is pending
    //        1 is accepted
    //        2 is declined
    //        3 is pickedUp/delivering
    //        4 is completed
    $status = 'Completed';
    $OrderID = $_POST['OrdID'];

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: http://localhost:10080/cmt322_project/RiderOrdersAccepted.php");
    exit();


}else{
    echo "An Error has occured.";
}

?>