<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Food Market - Admin</title>
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
				<a class="nav-link" href="#ManageAcc">Manage Accounts</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo "logout-manager.php"; ?>">Log Out</a>
			</li>
		</ul>
	</div>
</div>
</nav>

<div class="container-fluid">
	<div class="donation-container text-center">
	<div class="card shadow donation text-center donation">
        <h3 class="card-title donation-header">Total Donations</h3>
        <?php
            include_once "dbh2.inc.php";
            $queryDonation = "SELECT AmountDonated from auth_user WHERE NOT UserType='Admin'";
            $donationlist = mysqli_query($conn, $queryDonation);
            $totalDonation = 0;

            while($donation = mysqli_fetch_assoc($donationlist)){
                $totalDonation = $totalDonation + ((int)$donation['AmountDonated']);
            }
            echo "<h4 class='card-title totalDonation'>RM ". $totalDonation .".00</h4>";
            echo "<form action='admin-manager.php' method='post'><input class='btn btn-outline-secondary btn-lg' type='submit' name='action' value='Place Order'></form>";
        ?>
		
	</div>
	</div>
	<hr>
	
<div class="container-fluid padding">
	<h3 class="AdminPageHeader" id="ManageAcc"><u>Manage Accounts</u></h3>
	<div class="container-fluid">
	<nav class="navbar-expand-md AdminManageHeader">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link-1" href="#UserAcc">Client</a>
			</li>
			<li class="nav-item admin-manage">
				<a class="nav-link-1" href="#ResAcc">Restaurant</a>
			</li>
			<li class="nav-item admin-manage">
				<a class="nav-link-1" href="#RiderAcc">Rider</a>
			</li>
		</ul>
	</nav>
	</div>
    <hr>
    <h3 class='OrderHeader' id='UserAcc'>User Accounts</h3>
    <?php
        $queryClientList = "SELECT * from auth_user WHERE UserType='Customer'";
        $clientList = mysqli_query($conn, $queryClientList);
        $resultCheck = mysqli_num_rows($clientList);

        if($resultCheck > 0){
            while($client = mysqli_fetch_assoc($clientList)){
                echo "<div class='card shadow margin'><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
                echo "<h3 class='OrderHeader'>User #".$client['id']."</h3>";
                echo "<p class='cardContent'>";
                echo "<a><b>Name: </b>".$client['username']."</a><br>";
                echo "<a><b>Contact No.: </b>".$client['ContactNum']."</a><br>";
                echo "<a><b>Email: </b>".$client['email']."</a><br>";
                echo "<a><b>Address: </b>".$client['Address']."</a></p></div>";

                echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
                echo "<form action='admin-manager.php' method='post'><input type='hidden' name='UsrID' value='". $client['id'] ."'>";
                echo "<input class='btn btn-outline-secondary btn-lg' type='submit' name='action' value='Remove User'></form></div></div></div>";
            }


        }else{
            echo "<br>";
        }

    ?>
    
	<hr>
	<h3 class='OrderHeader' id='ResAcc'>Restaurant Accounts</h3>
    <?php
        $queryClientList = "SELECT * from auth_user WHERE UserType='Vendor'";
        $clientList = mysqli_query($conn, $queryClientList);
        $resultCheck = mysqli_num_rows($clientList);

        if($resultCheck > 0){
            while($client = mysqli_fetch_assoc($clientList)){

                $queryResInfo = "SELECT * from restaurant WHERE UserID='".$client['id']."'";
                $resInfo = mysqli_fetch_assoc(mysqli_query($conn, $queryResInfo));

                echo "<div class='card shadow margin'><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
                echo "<h3 class='OrderHeader'>Restaurant #".$resInfo['RestaurantID']."</h3>";
                echo "<p class='cardContent'>";
                echo "<a><b>Restaurant: </b>".$resInfo['RestaurantName']."</a><br>";
                echo "<a><b>Contact No.: </b>".$resInfo['ContactNum']."</a><br>";
                echo "<a><b>Email: </b>".$client['email']."</a><br>";
                echo "<a><b>Address: </b>".$resInfo['Address']."</a></p></div>";

                echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
                echo "<form action='admin-manager.php' method='post'><input type='hidden' name='UsrID' value='". $client['id'] ."'><input type='hidden' name='ResID' value='". $resInfo['RestaurantID'] ."'>";
                echo "<input class='btn btn-outline-secondary btn-lg' type='submit' name='action' value='Remove Restaurant'></form></div></div></div>";
            }


        }else{
            echo "<br>";
        }

    ?>


	<hr>
    <h3 class='OrderHeader' id='RiderAcc'>Rider Accounts</h3>
    <?php
        $queryClientList = "SELECT * from auth_user WHERE UserType='Rider'";
        $clientList = mysqli_query($conn, $queryClientList);
        $resultCheck = mysqli_num_rows($clientList);

        if($resultCheck > 0){
            while($client = mysqli_fetch_assoc($clientList)){
                echo "<div class='card shadow margin'><div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10'>";
                echo "<h3 class='OrderHeader'>User #".$client['id']."</h3>";
                echo "<p class='cardContent'>";
                echo "<a><b>Name: </b>".$client['username']."</a><br>";
                echo "<a><b>Contact No.: </b>".$client['ContactNum']."</a><br>";
                echo "<a><b>Email: </b>".$client['email']."</a><br>";
                echo "<a><b>Address: </b>".$client['Address']."</a></p></div>";

                echo "<div class='col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-center'>";
                echo "<form action='admin-manager.php' method='post'><input type='hidden' name='UsrID' value='". $client['id'] ."'>";
                echo "<input class='btn btn-outline-secondary btn-lg' type='submit' name='action' value='Remove Rider'></form></div></div></div>";
            }


        }else{
            echo "<br>";
        }

    ?>



</div>
	
	
	
	
	
	
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