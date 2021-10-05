<?php
session_start();

if (!$_SESSION['LoggedInUser']) {
	header("Location: index.php");
}

include ('includes/connection.php');

$LoggesInUser = $_SESSION['LoggedInUser'];

$QueryForUser = "SELECT ID FROM `users` WHERE name = '$LoggesInUser' ";
$ResultForUser = mysqli_query($Connection,$QueryForUser);
$row1 = mysqli_fetch_assoc($ResultForUser);
$IDUser = $row1['ID'];

$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser'"; //ВЫВОД ДАННЫХ О ВСЕХ КЛИЕНТАХ КОНКРЕТНОГО ПОЛЬЗОВАТЕЛЯ


if(isset($_GET['sort'])){ // ОБРАБОТКА УВЕДОМЛЕНИЙ И СОРТИРОВКА БД
	if($_GET['sort'] == 'SortByName'){

		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY clients.Name";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by Name<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	elseif($_GET['sort'] == 'SortByEmail'){

		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY contacts.email";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by Email<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	elseif($_GET['sort'] == 'SortByAddress'){

		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY contacts.address";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by Address<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	elseif($_GET['sort'] == 'SortByCompany'){

		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY clients.Company";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by Company<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	elseif($_GET['sort'] == 'SortByFirstOrder'){

		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY orders.first_order";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by First order<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	elseif($_GET['sort'] == 'SortByLastOrder'){
		
		$Query = "SELECT * FROM Clients INNER JOIN orders on clients.ID=orders.id_client INNER JOIN contacts on clients.ID = contacts.id_client where id_user = '$IDUser' ORDER BY orders.last_order";
		$AlertMsg = "<div class = 'alert alert-success'>Sorted by Last order<a class='close' data-dismiss='alert'>&times;</a></div>";
	}

}
$Result = mysqli_query($Connection, $Query);

if (isset($_GET['alert'])) {
	if ($_GET['alert'] == 'Success') {
		$AlertMsg = "<div class = 'alert alert-success'>New Client Added in Database.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
	elseif ($_GET['alert'] == 'UpdateSuccess') {
		$AlertMsg = "<div class = 'alert alert-success'>Client Updated Successfully.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
	elseif ($_GET['alert'] == 'Deleted') {
		$AlertMsg = "<div class = 'alert alert-success'>Client Deleted Successfully.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
}

mysqli_close($Connection);
include ('includes/header.php');

?>

<h1>Client Address Book</h1>

<?php
echo $AlertMsg; ?>

<table class="table table-striped table-bordered"> 

	<tr>
        <th><div class="text-center"><a href="clients.php?sort=SortByName" type="button" class="btn btn-info">Name</a></div></th>
        <th><div class="text-center"><a href="clients.php?sort=SortByEmail" type="button" class="btn btn-info">Email</a></div></th>
        <th></th>
        <th><div class="text-center"><a href="clients.php?sort=SortByAddress" type="button" class="btn btn-info">Address</a></div></th>
        <th><div class="text-center"><a href="clients.php?sort=SortByCompany" type="button" class="btn btn-info">Company</a></div></th>
        <th></th>
		<th></th>
		<th><div class="text-center"><a href="clients.php?sort=SortByFirstOrder" type="button" class="btn btn-info">First order</a></div></th>
		<th><div class="text-center"><a href="clients.php?sort=SortByLastOrder" type="button" class="btn btn-info">Last order</a></div></th>
        <th></th>
    </tr>

    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
		<th>Order</th>
		<th>First order</th>
		<th>Last order</th>
        <th>Edit</th>
    </tr>
    
    <?php

if (mysqli_num_rows($Result) > 0) {
	while ($Row = mysqli_fetch_assoc($Result)) {
		echo "<tr>";
		echo "<td>" . $Row['Name'] . "</td><td>" . $Row['email'] . "</td><td>" . $Row['phone'] . "</td><td>" . $Row['address'] . "</td><td>" . $Row['Company'] . "</td><td>" . $Row['Notes'] . "</td><td>" . $Row['orders'] . "</td><td>". $Row['first_order'] . "</td><td>" . $Row['last_order'] . "</td>";
		echo '<td><a href="edit.php?ID=' . $Row['ID'] . ' "type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> </a></td>';
		echo "</tr>";
	}
}
else {
	echo "<div class='alert alert-warning'>You have no Clients yet. </div>";
}

mysqli_close($Connection);
?>
    
    <tr>
        <td colspan="10"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include ('includes/footer.php');

?>