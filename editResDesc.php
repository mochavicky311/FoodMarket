<?php
session_start();
include_once "dbh2.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodMarket - Edit Restaurant Description</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet">
    <style>
        p, form, input{
            margin:.4rem;
        }

        p{
            font-size: 1.5rem;
        }

        form, input{
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><h2>Food Market</h2></a>
</div>
</nav>
<div style="margin:1.5rem;">
    <?php
        $ResID = $_POST['ResID'];
        //echo $_SESSION['userID'];
        $query = "SELECT * from restaurant WHERE RestaurantID='" . $ResID . "'";
        $result = mysqli_query($conn, $query);
        $conn->close();
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            while ($row = mysqli_fetch_assoc($result)){
                echo "<p><b>Edit the description of the Restaurant?</b></p>";
                echo "<form action='editResDesc-manager.php' method='post' enctype='multipart/form-data'>";
                echo "<label for='RestaurantName'>Restaurant Name:</label><input type='text' name='RestaurantName' value='".$row['RestaurantName']."'><br>";
                echo "<label for='RestaurantDesc'>Restaurant Description:</label><input type='text' name='ResDescription' value='".$row['Description']."'><br>";
                echo "<input type='hidden' name='ResID' value='".$row['RestaurantID']."'><input type='submit' name='action' value='Yes'><input type='submit' name='action' value='No'></form>";
            }
        }else{
            echo "No Product with the ID: " . $ResID;
        }    
    ?>
</div>

</body>
</html>