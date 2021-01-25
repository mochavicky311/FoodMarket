<?php
include_once "dbh2.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodMarket - Delete Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet">
    <style>
        p, form, input{
            margin:.4rem;
        }

        p {
            font-size: 1.5rem;
        }

        a, form, input{
            font-size: 1.2rem;
        }

        a{ margin-left:.4rem;}
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
        $prodID = $_POST['ProdId'];
        $query = "SELECT * from product WHERE ProductID=" . $prodID;
        $result = mysqli_query($conn, $query);
        $conn->close();
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            while ($row = mysqli_fetch_assoc($result)){
                echo "<p><b>Are you sure you want to delete the following Product?</b></p>";
                echo "<a>Product Name: " . $row['ProductName'] . "</a><br>";
                echo "<a>Product Price: " . $row['ProductPrice'] . "</a><br>";
                echo "<form action='deleteProd-manager.php' method='post'> <input type='hidden' name='ProdId' value='".$row['ProductID']."'><input type='hidden' name='ImgPath' value='".$row['ProductPic']."'><input type='submit' name='action' value='Yes'><input type='submit' name='action' value='No'></form>";
            }
        }else{
            echo "No Product with the ID: " . $prodID;
        }    
    ?>
</div>

</body>
</html>