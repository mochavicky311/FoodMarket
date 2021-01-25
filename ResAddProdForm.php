<?php
    include_once "dbh2.inc.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodMarket - Add New Product</title>
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
    <form action="upload-newProd-manager.php" method="post" enctype="multipart/form-data">
        <h2>New Product Info</h2>
        <label for="ProductName">Product Name:</label>
        <input type="text" name="ProductName" id="ProdName"><br>
        <label for="ProductPrice">Product Price:</label>
        <input type="text" name="ProductPrice" id="ProdPrice"><br>
        <label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
        <input type="submit" name="submit" value="Upload"><input type="submit" name="submit" value="cancel">
        <p style="font-size:1rem;"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5MB.</p>
    </form>
    </div>
</body>
</html>
