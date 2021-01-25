<?php
session_start();
include_once "dbh2.inc.php";
//check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //check if the file was uploaded without errors

    if($_POST['submit'] == 'cancel'){
        header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
        exit();
    }

    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
        
        $ProdName = $_POST["ProductName"];
        $ProdPrice = $_POST["ProductPrice"];
        $ResID = $_SESSION["ResID"];
        $userID = $_SESSION['userID'];
        //verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

        //verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

        //Verify MYME type of the file
            if(in_array($filetype, $allowed)){
                //check whether file exists before uploading it 
                if(file_exists("upload/" .$userID. $filename)){
                    echo $filename . " is already exists.";
                } else{
                    //move uploaded image to /upload directory
                    move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" .$userID.$filename);
                    //prepare sql query to insert data and path to DB 
                    echo $ProdName . "<br>";
                    echo $ProdPrice . "<br>";
                    $stmt = $conn->prepare("INSERT INTO product (RestaurantID, ProductName, ProductPrice, ProductPic) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $ResID, $ProductName, $ProductPrice, $ImgPath);
                    $ProductName = $_POST["ProductName"];
                    $ProductPrice = $_POST["ProductPrice"];
                    
                    $ImgPath = "upload/" .$userID. $filename;
                    $stmt->execute();

                    $stmt->close();
                    $conn->close();
                    
                    //set a session var indicating successful upload
                    $_SESSION["upload_success"] = TRUE;
                    //redirect to the previous page
                    header("Location: http://localhost:10080/cmt322_project/ResMainPage.php");
                    exit();
                    
                }
            } else{
                echo "Error: There was a problem uploading your file. Please try again.";
            }

    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }

}

?>