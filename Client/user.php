<?php
session_start();

include ('includes/functions.php');


if (isset($_POST['Create'])) { //РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ
    $FormName = ValidateFormData($_POST['Name']);
	$FormEmail = ValidateFormData($_POST['Email']);
	$FormPass = ValidateFormData($_POST['Password']);
	include ('includes/connection.php');

	$Query = "SELECT Email FROM Users WHERE Email = '$FormEmail'";//ПРОВЕРКА НА СУЩЕСТВОВАНИЕ ПОЛЬЗОВАТЕЛЯ В БД
	$Result = mysqli_query($Connection, $Query);
	if (mysqli_num_rows($Result) == 0) {
		
        $Insert = "INSERT INTO `Users` (`Name`, `Email`, `Password`) VALUES ('{$FormName}', '{$FormEmail}', '{$FormPass}');";
        $ResultIn = mysqli_query($Connection,$Insert);

        if($ResultIn){
            header("Location: index.php?alert=Success");
        }

	}
	else {
		$LoginError = "<div class='alert alert-danger'>Such an account exists. <a class='close' data-dismiss='alert'>&times;</a></div>";
	}
    mysqli_close($Connection);
}

include ('includes/header.php');

?>

<h1>Client Address Book</h1>
<p class="lead">Create a new account.</p>

<?php
echo $LoginError; ?>

<form class="form-inline" action="<?php
$_SERVER['PHP_SELF'] ?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Name</label>
        <input type="text" focusonly class="form-control" id="create-name" placeholder="name" name="Name" required>
    </div>
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" focusonly class="form-control" id="create-email" placeholder="email" name="Email" required>
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="create-password" placeholder="password" name="Password" required>
    </div>
    <button type="submit" class="btn btn-primary" name="Create">Create</button>
</form>
<div>

<?
include ('includes/footer.php');

?>