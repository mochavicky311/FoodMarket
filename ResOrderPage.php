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

<!-- Navigation bar -->
<nav class="navbar navbar-expand-md navbar-dark sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><h2>Food Market</h2></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				
				<?php
					//$userID = $_POST['userid'];
					$userID = $_SESSION['userID'];
					echo "<form action='ResMainPage.php' class='nav-link' method='post'><input type='hidden' name='userid' value='".$userID."'><input class='nav-link button-100' style='background: #1A1A1A; border:none;' type='submit' name='nav-order' value='Main'></form>";
					//echo "<a class='nav-link' href='ResOrderPage.php?userid='".$_GET['userid']."'>Orders</a>";
					//echo "<a class='nav-link' href='ResOrderPage.php?userid='".$userID."'>Orders</a>";
				?>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="#">Orders</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo "logout-manager.php"; ?>">Log Out</a>
			</li>
		</ul>
	</div>
</div>
</nav>

<!-- Jumbotron - for total orders -->
<?php

	include_once "dbh2.inc.php";

	//$ResID = 'R001';
	//get userID from $_POST and query for ResID
	
	$queryResID = "SELECT RestaurantID from restaurant WHERE UserID='".$userID."'";
	$idqueryresult = mysqli_fetch_assoc(mysqli_query($conn, $queryResID));
	$ResID = $idqueryresult['RestaurantID'];

	$query1 = "SELECT RestaurantName from restaurant WHERE RestaurantID='" . $ResID . "'";
	$queryOrder = "SELECT * from orderitem WHERE RestaurantID='" . $ResID . "'";
	$ResName = mysqli_fetch_assoc(mysqli_query($conn, $query1));
	$orders = mysqli_query($conn, $queryOrder);
	
	$resultCheck = mysqli_num_rows($orders);

	if($resultCheck > 0){
		echo "<div class='container-fluid'><div class='row jumbotron'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
		echo "<h2 class='RestaurantName'>" . $ResName['RestaurantName'] . "</h2>";
		
		$pendingOrder = 0;
		while ($rownum = mysqli_fetch_assoc($orders)){
			if ($rownum['Status'] == 'Pending'){
				$pendingOrder++;
			}
		}
		echo "<p class='RestaurantDescription'>Total number of orders: " . $pendingOrder . "</p></div></div></div><hr>"; 
		$orders = mysqli_query($conn, $queryOrder);
		
		echo "<div class='container-fluid padding'><h2 class='orderlistheader'>Orders Placed</h2>";
		while ($row_order = mysqli_fetch_assoc($orders)){
			if ($row_order['Status'] == 'Pending'){
				echo "<div class='card shadow' style='box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19); '><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
				echo "<h3 class='OrderHeader'>Order #" . $row_order['OrderID'] . "</h3>";
				$queryOrderProd = "SELECT * from orderproduct WHERE OrderID='". $row_order['OrderID'] ."'";
				$orderlist = mysqli_query($conn, $queryOrderProd);
				$numofProd = mysqli_num_rows($orderlist);
				$totalOrder = 0;
				if ($numofProd > 0){
					
					while($row_Prod = mysqli_fetch_assoc($orderlist)){
						$queryProdName = "SELECT ProductName, ProductPrice FROM product WHERE ProductID='".$row_Prod['ProductID']."'";
						$prodInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryProdName));
						echo "<a style=' font-size:1.5rem; padding-left:1.6rem;'>" . $prodInfo['ProductName'] . " x" . $row_Prod['Amount'] . "</a>";
						$totalOrder = $totalOrder + ((int)$prodInfo['ProductPrice'] * (int)$row_Prod['Amount']);
					}
					
					
					//query client info
					$queryClient = "SELECT UserName, ContactNum FROM auth_user WHERE id='". $row_order['UserID'] ."'";
					$clientInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryClient));
					echo "<p class='cardContent'><a style='font-size: 1.2rem;'><b>Client:</b> " . $clientInfo['UserName'] . "</a><br>";
					echo "<a style='font-size: 1.2rem;'><b>Contact No.:</b> " . $clientInfo['ContactNum'] . "</a></p></div>";
					//Accept Decline button
					echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
					echo "<p class='OrderTotal'>Total: RM". $totalOrder ."</p>";
					echo "<form action='order-manager.php' method='post'><input type='hidden' name='OrdID' value='". $row_order['OrderID'] ."'><input class='btn btn-outline-secondary margin' type='submit' name='action' value='Accept'>";
					echo "<input class='btn btn-outline-secondary margin' type='submit' name='action' value='Decline'></form></div></div></div>";
					
				}
			}
		}
		echo "</div><hr>";

		$orders = mysqli_query($conn, $queryOrder);
		echo "<div class='container-fluid padding'><h2 class='orderlistheader'>Orders Accepted</h2>";
		while ($row_order = mysqli_fetch_assoc($orders)){
			if ($row_order['Status'] == 'Accepted'){
				echo "<div class='card shadow' style='box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19); '><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
				echo "<h3 class='OrderHeader'>Order #" . $row_order['OrderID'] . "</h3>";
				$queryOrderProd = "SELECT * from orderproduct WHERE OrderID='". $row_order['OrderID'] ."'";
				$orderlist = mysqli_query($conn, $queryOrderProd);
				$numofProd = mysqli_num_rows($orderlist);
				$totalOrder = 0;
				if ($numofProd > 0){
					
					while($row_Prod = mysqli_fetch_assoc($orderlist)){
						$queryProdName = "SELECT ProductName, ProductPrice FROM product WHERE ProductID='".$row_Prod['ProductID']."'";
						$prodInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryProdName));
						echo "<a style=' font-size:1.5rem; padding-left:1.6rem;'>" . $prodInfo['ProductName'] . " x" . $row_Prod['Amount'] . "</a>";
						$totalOrder = $totalOrder + ((int)$prodInfo['ProductPrice'] * (int)$row_Prod['Amount']);
					}
					
					
					//query client info
					$queryClient = "SELECT UserName, ContactNum FROM auth_user WHERE id='". $row_order['UserID'] ."'";
					$clientInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryClient));
					echo "<p class='cardContent'><a style='font-size: 1.2rem;'><b>Client:</b> " . $clientInfo['UserName'] . "</a><br>";
					echo "<a style='font-size: 1.2rem;'><b>Contact No.:</b> " . $clientInfo['ContactNum'] . "</a></p></div>";
					//Accept Decline button
					echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
					echo "<p class='OrderTotal'>Total: RM". $totalOrder ."</p>";
					echo "<form action='order-manager.php' method='post'><input type='hidden' name='OrdID' value='". $row_order['OrderID'] ."'></form></div></div></div>";
					
				}
			}
		}
		echo "</div><hr>";

		$orders = mysqli_query($conn, $queryOrder);
		echo "<div class='container-fluid padding'><h2 class='orderlistheader'>Orders Completed</h2>";
		while ($row_order = mysqli_fetch_assoc($orders)){
			if ($row_order['Status'] == 'Completed'){
				echo "<div class='card shadow' style='box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19); '><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
				echo "<h3 class='OrderHeader'>Order #" . $row_order['OrderID'] . "</h3>";
				$queryOrderProd = "SELECT * from orderproduct WHERE OrderID='". $row_order['OrderID'] ."'";
				$orderlist = mysqli_query($conn, $queryOrderProd);
				$numofProd = mysqli_num_rows($orderlist);
				$totalOrder = 0;
				if ($numofProd > 0){
					
					while($row_Prod = mysqli_fetch_assoc($orderlist)){
						$queryProdName = "SELECT ProductName, ProductPrice FROM product WHERE ProductID='".$row_Prod['ProductID']."'";
						$prodInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryProdName));
						echo "<a style=' font-size:1.5rem; padding-left:1.6rem;'>" . $prodInfo['ProductName'] . " x" . $row_Prod['Amount'] . "</a>";
						$totalOrder = $totalOrder + ((int)$prodInfo['ProductPrice'] * (int)$row_Prod['Amount']);
					}
					
					
					//query client info
					$queryClient = "SELECT UserName, ContactNum FROM auth_user WHERE id='". $row_order['UserID'] ."'";
					$clientInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryClient));
					echo "<p class='cardContent'><a style='font-size: 1.2rem;'><b>Client:</b> " . $clientInfo['UserName'] . "</a><br>";
					echo "<a style='font-size: 1.2rem;'><b>Contact No.:</b> " . $clientInfo['ContactNum'] . "</a></p></div>";
					//Accept Decline button
					echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
					echo "<p class='OrderTotal'>Total: RM". $totalOrder ."</p></div></div></div>";			
				}
			}
		}

		echo "</div>";
	}else{
		echo "<a style='font-size: 2rem; padding: 2rem 1rem;'>There is no order for now.'".$userID."'</a>";
	}    
?>
<!--
<div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<h2 class="RestaurantName">Subaidah</h2>
			<p class="RestaurantDescription">
			Total number of orders: 5
			</p>
		</div>
	</div>
</div>
-->
<!--<hr>-->
<!-- Orders Lists in Cards -->
<!--
<div class="container-fluid padding">
	<h2 class="orderlistheader">Orders Placed</h2>
	<div class="card shadow">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<h3 class="OrderHeader">Tandoori</h3>
			<p class="cardContent">
				<a><b>Client:</b> Ms. Vicky Yew</a><br>
				<a><b>Contact No.:</b> 011-1234567</a><br>
				<a><b>Amount:</b> 1</a> <br>
				<a><b>Time:</b> 23 Dec 2020 06:00pm</a>
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center">
			<p class="OrderTotal">Total: RM 7.00</p>
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg margin">Accept
			</button></a>
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg margin">Decline
			</button></a>
		</div>
	</div>
	</div>
	<br>
	<div class="card shadow">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<h3 class="OrderHeader">Nasi Kandar</h3>
			<p class="cardContent">
				<a><b>Client:</b> Mr. Pang Yi Shen</a><br>
				<a><b>Contact No.:</b> 012-9876543</a> <br>
				<a><b>Amount:</b> 1</a><br>
				<a><b>Time:</b> 23 Dec 2020 06:00pm</a>
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center">
			<p class="OrderTotal">Total: RM 6.00</p>
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg margin">Accept
			</button></a>
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg margin">Decline
			</button></a>
		</div>
	</div>
	</div>

</div>
<hr>
<div class="container-fluid padding">
	<h2 class="orderlistheader">Orders Accepted</h2>
	<div class="card shadow">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<h3 class="OrderHeader">Tandoori</h3>
			<p class="cardContent">
				<a><b>Client:</b> Ms. Vicky Yew</a><br>
				<a><b>Contact No.:</b> 011-1234567</a><br>
				<a><b>Amount:</b> 1</a> <br>
				<a><b>Time:</b> 23 Dec 2020 06:00pm</a>
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center">
			<p class="OrderTotal">Total: RM 7.00</p>
			<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg margin">Picked Up
			</button></a>
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