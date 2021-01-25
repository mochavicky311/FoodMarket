<?php
	session_start();
	include_once "dbh2.inc.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Food Market - Restaurant</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>
<!--Navigation Bar-->
<nav class="navbar navbar-expand-md navbar-dark sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><h2>Food Market</h2></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Main</a>
			</li>
			<li class="nav-item">
				
				<?php
					if(!isset($_GET['userid'])){
						//get from session
						$userID = $_SESSION['userID'];
					}else{
						$_SESSION['userID'] = $_GET['userid'];
						$userID = $_SESSION['userID'];
					}
					
					/*
					if(!isset($_POST['userid'])){
						$userID = $_GET['userid'];
					}else{
						$userID = $_POST['userid'];
					}
					*/
					echo "<form action='ResOrderPage.php' method='post'><input type='hidden' name='userid' value='".$userID."'><input class='nav-link ' style='background: #1A1A1A; border:none;' type='submit' name='nav-order' value='Orders'></form>";
					//echo "<a class='nav-link' href='ResOrderPage.php?userid='".$_GET['userid']."'>Orders</a>";
					//echo "<a class='nav-link' href='ResOrderPage.php?userid='".$userID."'>Orders</a>";
				?>
				
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo "logout-manager.php"; ?>">Log Out</a>
			</li>
		</ul>
	</div>
</div>
</nav>

<!-- Jumbotron -->
<div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<?php
				//$ResID = 'R001';
				//get userID from $_POST and query for ResID
				//echo $_POST['userid'];
				
				$queryResID = "SELECT RestaurantID from restaurant WHERE UserID='".$userID."'";
				$idqueryresult = mysqli_fetch_assoc(mysqli_query($conn, $queryResID));
				$ResID = $idqueryresult['RestaurantID'];
				$_SESSION['ResID'] = $idqueryresult['RestaurantID'];

				$query = "SELECT * from restaurant WHERE RestaurantID='" . $ResID . "'";
				$result = mysqli_query($conn, $query);
				$resultCheck = mysqli_num_rows($result);
		
				if($resultCheck > 0){
					while ($row = mysqli_fetch_assoc($result)){
						echo "<h2 class='RestaurantName' style='padding-top:4rem;'>".$row['RestaurantName']."</h2>";
						echo "<p class='RestaurantDescription'>".$row['Description']."</p>";
					}
				}else{
					echo "No Product with the ID: " . $idqueryresult['RestaurantID'];
				}    
			
			?>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 padding" style="padding-top:4rem;">
			<?php
				echo "<form action='editResDesc.php' method='post'><input type='hidden' name='ResID' value='".$ResID."'><input type='hidden' name='userid' value='".$userID."'>";
				echo "<input class='btn btn-outline-secondary margin' type='submit' name='editDesc' value='Edit Description'/></form>";
				echo "<form action='ResAddProdForm.php' method='post'><input class='btn btn-outline-secondary margin' type='submit' name='addProd' value='Add Product'/></form>";
				
			?>
		<!--
		<form action="editResDesc.php" method="post">
			<input type='hidden' name='ResID' value='R001'>
			<input class="btn btn-outline-secondary margin" type="submit" name="editDesc" value="Edit Description"/>
		</form>
		<form action="ResAddProdForm.php" method="post">	
			<input class="btn btn-outline-secondary margin" type="submit" name="addProd" value="Add Product"/>
		</form>
			-->
		<!--
			<a href="#" class="btn btn-outline-secondary margin">
			Edit Description
            </a>
            <a href="#" class="btn btn-outline-secondary margin">Add new product</a>
		-->
		
		
		</div>
	</div>
</div>


<div class="container-fluid padding">
<div class="row padding">
<?php

    
    if ($conn-> connect_error){
        die("Connection failed:". $conn-> connect_error);
    }
        
        $sql = "SELECT * from product WHERE RestaurantID='".$ResID."'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            while ($row = mysqli_fetch_assoc($result)){
                echo "<div class='col-md-4'><div class='card'><img class='card-img-top' src='" . $row['ProductPic'] . "'><div class='card-body'>";
                echo "<h4 class='card-title'>" . $row['ProductName'] . "</h4><p class='card-text'>RM".$row['ProductPrice'] . "</p>";
				echo "<div style='display:inline;'><a><form action='updateProd.php' method='post' enctype='multipart/form-data' style='display:inline;'><input type='hidden' name='ProdId' value='".$row['ProductID']."'><input type='submit' class='btn btn-outline-secondary margin' name='updateProd' value='Update'></form></a>";
				echo "<a><form action='deleteProd.php' method='post' enctype='multipart/form-data' style='display:inline;'><input type='hidden' name='ProdId' value='".$row['ProductID']."'><input type='submit' class='btn btn-outline-secondary margin' name='deleteProd' value='Delete'></form></a></div></div></div></div>";
			}
        }
        else{
            echo "<p>" . $sql . "</p>";
        }

        $conn-> close();
    
?>

</div>
</div>


<!-- Cards - Menus -->
<!--
<div class="container-fluid padding">
<div class="row padding">
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/roticanai.png">
			<div class="card-body">
				<h4 class="card-title">Roti Canai</h4>
				<p class="card-text">RM 1.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/nasikandar.png">
			<div class="card-body">
				<h4 class="card-title">Nasi Kandar</h4>
				<p class="card-text">RM 6.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/tandoori.png">
			<div class="card-body">
				<h4 class="card-title">Tandoori Chicken</h4>
				<p class="card-text">RM 7.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/roticanai.png">
			<div class="card-body">
				<h4 class="card-title">Roti Canai</h4>
				<p class="card-text">RM 1.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/nasikandar.png">
			<div class="card-body">
				<h4 class="card-title">Nasi Kandar</h4>
				<p class="card-text">RM 6.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<img class="card-img-top" src="img/tandoori.png">
			<div class="card-body">
				<h4 class="card-title">Tandoori Chicken</h4>
				<p class="card-text">RM 7.00</p>
				<a href="#" class="btn btn-outline-secondary">Update</a>
				<a href="#" class="btn btn-outline-secondary">Delete</a>
			</div>
		</div>
	</div>
</div>
</div>
-->

<footer>
<div class="container-fluid padding">
<div class="row text-center">
	<div class="col-md-4">
		<p>Contact Us: 555-555-5555</p>
	</div>
	
	<div class="col-md-4">
		<p>Our hours: Daily 10am - 5pm</p>
	</div>
	
	<div class="col-md-4">
		<p>Please Dont contact us</p>
	</div>
</div>
</div>
</footer>

</body>

</html>