<?php
session_start();
error_reporting(0);

if ($_SESSION['LoggedInUser']) { 
	header("Location: clients.php");
}

include ('includes/functions.php');

if (isset($_GET['alert'])) {
	if ($_GET['alert'] == 'Success') {
        $LoginError = "<div class = 'alert alert-success'>New Account Added in Database.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

if (isset($_POST['Login'])) {
	$FormEmail = ValidateFormData($_POST['Email']);
	$FormPass = ValidateFormData($_POST['Password']);
	include ('includes/connection.php');

	$Query = "SELECT Name, Password FROM Users WHERE Email = '$FormEmail'"; // ПРОВЕРКА НАЛИЧИЯ ПОЛЬЗОВАТЕЛЯ В БАЗЕ
	$Result = mysqli_query($Connection, $Query);
	if (mysqli_num_rows($Result) > 0) {
		while ($Row = mysqli_fetch_assoc($Result)) {
			$Name = $Row['Name'];
			$HashedPass = $Row['Password'];

		}
		
		if ($FormPass==$HashedPass) { //ПРОВЕРКА ПАРОЛЯ
			$_SESSION['LoggedInUser'] = $Name;
			header("Location: clients.php");
		}
		else {
			$LoginError = "<div class='alert alert-danger'>Wrong Username / Password Combination. Try Again.</div>";
		}
	}
	else {
		$LoginError = "<div class='alert alert-danger'>No such user in Database. Please Try Again. <a class='close' data-dismiss='alert'>&times;</a></div>";
	}

	mysqli_close($Connection);
}


include ('includes/header.php');

?>

<h1>Client Address Book</h1>
<p class="lead">Log in to your account.</p>
<?php
echo $LoginError; ?>
<form class="form-inline" action="<?php
$_SERVER['PHP_SELF'] ?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="text" focusonly class="form-control" id="login-email" placeholder="email" name="Email" value="<?php
echo $FormEmail; ?>">
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="password" name="Password">
    </div>
    <button type="submit" class="btn btn-primary" name="Login">Login</button>
</form>
<a href="user.php">Create a new account</a>

<?php
include ('includes/footer.php');

?>