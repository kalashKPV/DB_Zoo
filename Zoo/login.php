<?php
session_start();
?>
<?php include("includes/header.php"); ?>	 
<?php
include("includes/connections.php");
if(isset($_SESSION["session_username"])){
	// вывод "Session is set"; // в целях проверки
	header("Location: Visitor/main.php");
} 
if(isset($_SESSION["session_username1"])){
	// вывод "Session is set"; // в целях проверки
	header("Location: Employee/main.php");
}

if(isset($_POST["login"])){

	if(!empty($_POST['username']) && !empty($_POST['password'])) {
		$username=htmlspecialchars($_POST['username']);
		$password=htmlspecialchars($_POST['password']);
		$query =mysqli_query($con,"SELECT * FROM usertbl WHERE username='".$username."' AND password='".$password."'");
		$numrows=mysqli_num_rows($query);
		if($numrows!=0)
		{
			while($row=mysqli_fetch_assoc($query))
			{
				$dbusername=$row['username'];
				$dbpassword=$row['password'];
				$dbis_admin=$row['is_admin'];
			}
			if($username == $dbusername && $password == $dbpassword && (0 == $dbis_admin || 1 == $dbis_admin))
			{
	// старое место расположения
	//  session_start();
				$_SESSION['session_username']=$username;	 
				/* Перенаправление браузера */
				header("Location: Visitor/main.php");
			} else if($username == $dbusername && $password == $dbpassword && 2 == $dbis_admin ){
				$_SESSION['session_username1']=$username;	 
				/* Перенаправление браузера */
				header("Location: Employee/main.php");
			}
		} else {
	//  $message = "Invalid username or password!";

			$message = "Invalid username or password!";
		}
	} else {
		$message = "All fields are required!";
	}
}
?>

<?php include("includes/header.php"); ?>
<div class="container mlogin">
	<div id="login">
		<h1>Вхід</h1>
		<form action="" id="loginform" method="post"name="loginform">
			<p><label for="user_login">Ім'я користувача<br>
				<input class="input" id="username" name="username"size="20"
				type="text" value=""></label></p>
				<p><label for="user_pass">Пароль<br>
					<input class="input" id="password" name="password"size="20"
					type="password" value=""></label></p> 
					<?php 
					echo "<p id = message> $message </p>"; 
					?>
					<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
					<p class="regtext">Ще не зареєстровані?<a href= "register.php">Реєстрація</a>!</p>
				</form>
			</div>
		</div>
		<?php include("includes/footer.php"); ?>		
