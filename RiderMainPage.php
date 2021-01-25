<?php
	session_start();
	include_once "dbh2.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Food Market - Rider</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>

<!-- Navigation Bar -->
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
				<a class="nav-link" href="RiderOrdersAccepted.php">Orders Accepted</a>
			</li>
			<!--
			<li class="nav-item">
				<a class="nav-link" href="RiderOrdersCompleted.html">Orders Completed</a>
			</li>
			-->
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
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
                    <h4 class="card-title">Rides Completed</h4>
                    <?php
                        if(!isset($_GET['userid'])){
                            //get from session
                            $RiderID = $_SESSION['userID'];
                        }else{
                            $_SESSION['userID'] = $_GET['userid'];
                            $RiderID = $_SESSION['userID'];
                        }
                    
                        $query = "SELECT * FROM orderitem WHERE RiderID='".$RiderID."' AND Status='Completed'";
                        $rides = mysqli_query($conn, $query);
                        $numofRides = mysqli_num_rows($rides);
                        echo "<p class='card-text'>You have completed ". $numofRides . " rides this month.</p>";
                    ?>
					
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
                    <h4 class="card-title">Total Earned this Month</h4>
                    <?php
                        
                        $query = "SELECT * FROM orderitem WHERE RiderID='".$RiderID."' AND Status='Completed'";
                        $rides = mysqli_query($conn, $query);
                        $numofRides = mysqli_num_rows($rides);
                        $totalEarned = 0;
                        if($numofRides > 0){
                            
                            while($row = mysqli_fetch_assoc($rides)){
                                $totalEarned = $totalEarned + ((int)$row['DeliveryFee']);
                            }
                        }
                        echo "<p class='card-text'>RM ".$totalEarned.".00</p>";
                    ?>
					
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Card list for available deliveries -->
<div class="container-fluid padding">
    <h2 class="orderlistheader">Orders to be delivered</h2>
    <?php
        $query = "SELECT * FROM orderitem WHERE Status='Accepted'";
        $result = mysqli_query($conn, $query);
        $numofOrders = mysqli_num_rows($result);

        if($numofOrders > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<div class='card shadow margin'><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
                //orderID
                echo "<h3 class='OrderHeader'>Order #".$row['OrderID']."</h3><p class='cardContent'>";
                $queryRes = "SELECT RestaurantName, Address, ContactNum FROM restaurant WHERE RestaurantID='".$row['RestaurantID']."'";
                $ResResult = mysqli_fetch_assoc(mysqli_query($conn, $queryRes));
                echo "<a><b>".$ResResult['RestaurantName']."</b></a></br>";
                echo "<a>".$ResResult['Address']."</a></br>";
                echo "<a>Contact No.: ".$ResResult['ContactNum']."</a></br>";
                //query restaurant name
                //pick up address
                //res contact no.
                $queryClient = "SELECT UserName, ContactNum FROM auth_user WHERE id='".$row['UserID']."'";
                $ClientResult = mysqli_fetch_assoc(mysqli_query($conn, $queryClient));
                echo "<a><b>Client: </b>".$ClientResult['UserName']."</a><br>";
                echo "<a><b>Contact No.: </b>".$ClientResult['ContactNum']."</a><br>";
                echo "<a><b>Deliver to: </b>".$row['AddressToDelivery']."</a>";
                //Client
                //client contact
                //Client Address
                echo "</p></div>";
                echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
                echo "<form action='delivery-manager.php' method='post'><input type='hidden' name='OrdID' value='". $row['OrderID'] ."'><input type='hidden' name='RiderID' value='". $RiderID ."'>";
                echo "<input class='btn btn-outline-secondary btn-lg' type='submit' name='action' value='Accept'></form></div></div></div>";
            }
        }
    ?>

</div>










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