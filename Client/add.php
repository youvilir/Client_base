<?php
session_start();

if (!$_SESSION['LoggedInUser']) {
	header("Location: index.php");
}

include ("includes/connection.php");

include ("includes/functions.php");

if (isset($_POST['AddClient'])) {
	$ClientName = $ClientEmail = $ClientPhone = $ClientAddress = $ClientCompany = $ClientNotes = $ClientFirst_order = $ClientLast_order = $ClientOrder ="";
	if (!$_POST['ClientName']) {
		$NameError = "Please enter Client/'s Name <br />";
	}
	else {
		$ClientName = ValidateFormData($_POST['ClientName']);
	}

	if (!$_POST['ClientEmail']) {
		$EmailError = "Please enter Client/'s Email <br />";
	}
	else {
		$ClientEmail = ValidateFormData($_POST['ClientEmail']);
	}

	$ClientPhone = ValidateFormData($_POST['ClientPhone']);
	$ClientAddress = ValidateFormData($_POST['ClientAddress']);
	$ClientCompany = ValidateFormData($_POST['ClientCompany']);
	$ClientNotes = ValidateFormData($_POST['ClientNotes']);
    $ClientFirst_order = ($_POST['ClientFirst_order']);
    $ClientLast_order = ($_POST['ClientLast_order']);
    $ClientOrder = ValidateFormData($_POST['ClientOrder']);
    $LoggesInUser = $_SESSION['LoggedInUser'];

    if(!$_POST['ClientFirst_order']) {
        $ClientFirst_order = (date('Y-m-d'));

    }
    if(!$_POST['ClientLast_order']) {
        $ClientLast_order = (date('Y-m-d'));
    }
    
    $QueryForUser = "SELECT ID FROM `users` WHERE name = '$LoggesInUser' ";
    $ResultForUser = mysqli_query($Connection,$QueryForUser);
    $row = mysqli_fetch_assoc($ResultForUser);
    $IDUser = $row['ID'];
    
	if ($ClientName && $ClientEmail) {
		$QueryForClient = "INSERT INTO `Clients`(`ID`, `Name`, `Company`, `Notes`, `Date` , `id_user`) VALUES (NULL, '$ClientName', '$ClientCompany', '$ClientNotes', CURRENT_TIMESTAMP, '$IDUser')";
		$ResultForClient = mysqli_query($Connection, $QueryForClient);
        
		if ($ResultForClient) {
            
            $QueryForIdClient1 = "SELECT * FROM Clients WHERE id_user = '$IDUser' ORDER BY ID DESC LIMIT 1";
            $ResultForIdClient1 = mysqli_query($Connection, $QueryForIdClient1);
            if($ResultForIdClient1){
                $rowID = mysqli_fetch_assoc($ResultForIdClient1);
                $IDClient = $rowID['ID'];
                

                $QueryForContact = "INSERT INTO `contacts`(`ID`, `address`, `email`, `phone`, `id_client`) VALUES (NULL, '$ClientAddress', '$ClientEmail', '$ClientPhone', '$IDClient')";
                $ResultForClient = mysqli_query($Connection, $QueryForContact);

                $QueryForOrder = "INSERT INTO `orders`(`id`, `orders`, `first_order`, `last_order`, `id_client`) VALUES (NULL, '$ClientOrder', '$ClientFirst_order', '$ClientLast_order', '$IDClient')";
                $ResultForOrder = mysqli_query($Connection, $QueryForOrder);

                if($ResultForClient && $ResultForOrder)
                header("Location: clients.php?alert=Success");
                else echo "Error: " . $ResultForOrder . "<br />" . mysqli_error($Connection);
     
            }
		}
		else {
			echo "Error: " . $Query . "<br />" . mysqli_error($Connection);
		}
	}
}

mysqli_close($Connection);
include ('includes/header.php');

?>

<h1>Add Client</h1>

<form action="<?php
echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <small><?php
echo $NameError; ?></small>
        <input type="text" class="form-control input-lg" id="client-name" name="ClientName" value="<?php echo $ClientName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <small><?php
echo $EmailError; ?></small>
        <input type="text" class="form-control input-lg" id="client-email" name="ClientEmail" value="<?php echo $ClientEmail; ?>" >
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="ClientPhone" value="<?php echo $ClientPhone; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="ClientAddress" value="<?php echo $ClientAddress; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="ClientCompany" value="<?php echo $ClientCompany; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-firsto_rder">First order</label>
        <input type="date" class="form-control input-lg" id="client-first_order" name="ClientFirst_order"></input>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-alst_order">Last order</label>
        <input type="date" class="form-control input-lg" id="client-last_order" name="ClientLast_order"></input>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="ClientNotes"><?php echo $ClientNotes; ?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-order">Order</label>
        <textarea type="text" class="form-control input-lg" id="client-order" name="ClientOrder"><?php echo $ClientOrder; ?></textarea>
    </div>
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="AddClient">Add Client</button>
    </div>
    
</form>

<?php
include ('includes/footer.php');

?>